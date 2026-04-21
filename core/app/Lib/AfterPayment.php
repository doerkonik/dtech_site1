<?php

namespace App\Lib;

use App\DomainRegisters\Register;
use App\HostingModule\HostingManager;
use App\Models\AdminNotification;
use App\Models\BillingSetting;
use App\Models\Domain;
use App\Models\DomainRegister;
use App\Models\GeneralSetting;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Lib\SendServiceEmail;

class AfterPayment{ 

    public function pay($invoice){
     
        $user = $invoice->user;
        $order = $invoice->order;
        $amount = $invoice->amount;

        $user->balance -= $amount;
        $user->save();

        $invoice->status = 1; //1 means Paid
        $invoice->paid_date = Carbon::now(); 
        $invoice->reminder = $invoice->updateReminder();
        $invoice->save();

        $urlPath = urlPath('admin.dashboard');

        if(@$order){ //When trying to pay an order invoice
            $urlPath = urlPath('admin.orders.details', $order->id);

            $domainsId = InvoiceItem::where('invoice_id', $invoice->id)->where('item_type', 1)->get('domain_id')->toArray();
            $domains = Domain::whereIn('id', $domainsId)->get();
            
            $this->serviceProcessing(@$order->hostings ?? []);
            $this->domainProcessing(@$domains ?? [], $invoice);

            // ✅ FIX: Mark order as Active after all services are processed
            $this->finalizeOrder($order);
        }
        elseif(@$invoice->hosting_id){ //When trying to pay only hosting/service invoice 
            $urlPath = urlPath('admin.order.hosting.details', @$invoice->hosting_id);
            $this->serviceRecurringProcessing($invoice);  
        }
        elseif(@$invoice->domain_id){ //When trying to pay only domain register/renew invoice
            $urlPath = urlPath('admin.order.domain.details', @$invoice->domain_id);
            
            $invoiceItem = InvoiceItem::where('invoice_id', $invoice->id)->where('item_type', 1)->where('domain_id', $invoice->domain_id)->first();
            $this->domainRenewProcessing($invoice->domain, $invoiceItem); 
        }
     
        $transaction = new Transaction();
        $transaction->invoice_id = $invoice->id;
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->trx = getTrx();
        $transaction->details = 'Payment';
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Payment from '.$user->username;
        $adminNotification->click_url = $urlPath; 
        $adminNotification->save();

        if($order){
            SendServiceEmail::orderNotify($invoice, $order);
        }
    }

    // ✅ NEW: Finalize order — set order to Active after payment processed
    private function finalizeOrder($order){
        if($order && $order->status == 2){ // 2 = Pending
            $order->status = 1;            // 1 = Active
            $order->save();
        }
    }

    public function serviceProcessing($hostings){
        
        foreach($hostings as $hosting){
        
            $product = $hosting->product; 
            $hosting->invoice = 0; //0 means empty invoice/allow creating a new invoice
        
            if($hosting->stock_control){
                $product->decrement('stock_quantity');
                $product->save();
            }

            if($product->process() == 'automation'){ 
                $server = @$hosting->server;
                $serverGroup = @$server->group;

                if($server && $serverGroup){
                    $execute = HostingManager::init($serverGroup)->create($hosting);
              
                    if($execute['success']){
                        $hosting->status = 1; //1 means active
                        $hosting->save(); // ✅ Save FIRST so username/password exist in DB for email
                        SendServiceEmail::serviceNotify($hosting); // ✅ then send email
                    } else {
                        \Log::error('AfterPayment: Hosting #' . $hosting->id . ' provisioning failed: ' . ($execute['message'] ?? 'Unknown error'));
                        $hosting->status = 1;
                        $hosting->save(); // ✅ Save FIRST
                        SendServiceEmail::serviceNotify($hosting); // ✅ notify even if provisioning failed
                    }
                } else {
                    // No server assigned — mark active and notify
                    $hosting->status = 1;
                    $hosting->save(); // ✅ Save FIRST
                    SendServiceEmail::serviceNotify($hosting); // ✅ send email
                    \Log::warning('AfterPayment: Hosting #' . $hosting->id . ' has no server assigned. Marked active without provisioning.');
                }

            } else {
                // Manual product — mark active and notify
                $hosting->status = 1;
                $hosting->save(); // ✅ Save FIRST
                SendServiceEmail::serviceNotify($hosting); // ✅ send email
            }

            // ✅ hosting already saved inside each branch above — no duplicate save needed
        }
    }

    public function domainProcessing($domains, $invoice){
      
        foreach($domains as $domain){
            $invoiceItem = InvoiceItem::where('invoice_id', $invoice->id)
                ->where('domain_id', $domain->id)
                ->where('item_type', 1)
                ->where('reg_period', '!=', 0)
                ->where('next_due_date', '!=', null)
                ->first();

            if(!$invoiceItem){
                $this->domainRegister($domain);
            }
        } 
    } 

    public function serviceRecurringProcessing($invoice){
        $hosting = $invoice->hosting;
    
        if(!$hosting){
            return false;
        }

        $billingSetting = BillingSetting::first();

        $billing = @billingCycle(@$hosting->billing_cycle, true);
        $days = @$billingSetting->create_invoice->{@$billing['billing_cycle']};

        if(!$days){
            $days = $billingSetting->create_default_invoice_days;
        }
        
        $hosting->next_due_date = $invoice->next_due_date;
        $hosting->next_invoice_date = Carbon::parse($hosting->next_due_date)->subDays($days)->toDateTimeString();
        $hosting->invoice = 0; //0 means empty invoice/allow creating a new invoice
        $hosting->save();
    }

    public function domainRenewProcessing($domain, $invoiceItem){
        
        $register = new Register($domain->register->alias);
        $register->domain = $domain;
        $register->command = 'renew';
        $execute = $register->run();

        if(!$execute['success']){
            return ['success'=>false, 'message'=>$execute['message']];
        }

        $billingSetting = BillingSetting::first();
        $days = @$billingSetting->create_domain_invoice_days;

        if(!$days){
            $days = $billingSetting->create_default_invoice_days;
        }
   
        $domain->next_due_date = $invoiceItem->next_due_date;
        $domain->expiry_date = $invoiceItem->next_due_date;
        $domain->reg_period = $invoiceItem->reg_period;
        $domain->next_invoice_date = Carbon::parse($domain->next_due_date)->subDays($days)->toDateTimeString();
        $domain->recurring_amount = $invoiceItem->recurring_amount;
        $domain->invoice = 0; //0 means empty invoice/allow creating a new invoice
        $domain->save();

        SendServiceEmail::domainRenewNotify($domain);
        return ['success'=>true];
    }
 
    private function domainRegister($domain){
       
        $general = GeneralSetting::first('auto_domain_register');
        $domainRegister = DomainRegister::default()->first();

        if(!$domain->domain_register_id){
            $domain->domain_register_id = $domainRegister->id ?? 0;
        }
        $domain->invoice = 0;
        $domain->save();
        
        if($general->auto_domain_register && $domainRegister){
           
            $register = new Register($domain->register->alias);
            $register->domain = $domain;
            $register->command = 'register';
            $execute = $register->run();

            if($execute['success']){
                $domain->status = 1; //1 means active
                $domain->save();
                SendServiceEmail::domainNotify($domain);
            }
        }
    }
}
<?php

namespace App\Http\Controllers\Gateway\SslCommerz;

use App\Constants\Status;
use App\Models\Deposit;
use App\Models\User;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        $parameters = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        $alias = $deposit->gateway->alias;

        $postData = [];

        $postData['store_id']     = $parameters->store_id;
        $postData['store_passwd'] = $parameters->store_password;

        $postData['total_amount'] = $deposit->final_amount;
        $postData['currency']     = $deposit->method_currency;
        $postData['tran_id']      = $deposit->trx;

        $postData['success_url']  = route('ipn.' . $alias);
        $postData['fail_url']     = $deposit->failed_url;
        $postData['cancel_url']   = $deposit->failed_url;
        $postData['ipn_url']      = route('ipn.' . $alias);

        $postData['product_name']     = $deposit->product_name;
        $postData['product_category'] = $deposit->product_category;
        $postData['product_profile']  = $deposit->product_profile;

        $postData['shipping_method'] = $deposit->shipping_method ?? 'NO';

        if (auth()->check()) {
            $user = auth()->user();

            // ✅ Store user ID + trx in session before going to SSLCommerz
            session([
                'sslcommerz_user_id'  => $user->id,
                'sslcommerz_trx'      => $deposit->trx,
                'sslcommerz_guard'    => 'web',
            ]);

            $postData['cus_name']    = $user->fullname;
            $postData['cus_email']   = $user->email;
            $postData['cus_phone']   = $user->phone;
            $postData['cus_add1']    = $user->address  ?? '';
            $postData['cus_city']    = $user->city     ?? '';
            $postData['cus_country'] = $user->country  ?? '';

        } elseif (auth('admin')->check()) {
            $admin = auth('admin')->user();

            // ✅ Store admin ID + trx in session before going to SSLCommerz
            session([
                'sslcommerz_user_id'  => $admin->id,
                'sslcommerz_trx'      => $deposit->trx,
                'sslcommerz_guard'    => 'admin',
            ]);

            $postData['cus_name']    = $admin->name    ?? 'Admin';
            $postData['cus_email']   = $admin->email   ?? '';
            $postData['cus_phone']   = $admin->mobile  ?? '';
            $postData['cus_add1']    = '';
            $postData['cus_city']    = '';
            $postData['cus_country'] = '';
        }

        $postData['emi_option'] = "0";

        // 🌐 Sandbox — change to live URL for production
        $paymentUrl = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

        $response = CurlRequest::curlPostContent($paymentUrl, $postData);

        if (!$response) {
            return json_encode(['error' => true, 'message' => 'Empty response from gateway']);
        }

        $response = json_decode($response, true);

        if (!isset($response['status']) || $response['status'] != 'SUCCESS') {
            return json_encode(['error' => true, 'message' => 'Gateway error', 'data' => $response]);
        }

        $gatewayUrl = $response['GatewayPageURL'] ?? $response['redirectGatewayURL'] ?? null;

        if (!$gatewayUrl) {
            return json_encode(['error' => true, 'message' => 'No redirect URL found', 'data' => $response]);
        }

        return json_encode(['redirect' => true, 'redirect_url' => $gatewayUrl]);
    }

    public function ipn(Request $request)
    {
        $track  = $request->tran_id;
        $status = $request->status;

        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

        if (!$deposit) {
            return redirect('/')->with('error', 'Deposit not found');
        }

        // ✅ Always restore session first before doing anything
        $this->restoreSession($deposit);

        // ✅ Handle GET redirect from SSLCommerz browser redirect
        if ($request->isMethod('GET')) {

            // Already paid by server IPN POST — just redirect
            if ($deposit->status == Status::PAYMENT_SUCCESS) {
                session()->forget(['sslcommerz_user_id', 'sslcommerz_trx', 'sslcommerz_guard']);
                $notify[] = ['success', 'Payment completed successfully'];
                return redirect($deposit->success_url)->withNotify($notify);
            }

            // Payment still pending — process it now from GET
            if ($status == 'VALID' && $deposit->status == Status::PAYMENT_INITIATE) {
                PaymentController::userDataUpdate($deposit);
                session()->forget(['sslcommerz_user_id', 'sslcommerz_trx', 'sslcommerz_guard']);
                $notify[] = ['success', 'Payment captured successfully'];
                return redirect($deposit->success_url)->withNotify($notify);
            }

            $notify[] = ['error', 'Invalid request'];
            return redirect($deposit->failed_url)->withNotify($notify);
        }

        // ✅ Handle server-to-server IPN POST
        if ($status == 'VALID' && $deposit->status == Status::PAYMENT_INITIATE) {

            if (isset($_POST['verify_sign']) && isset($_POST['verify_key'])) {

                $preDefineKey = explode(',', $_POST['verify_key']);
                $newData = [];

                foreach ($preDefineKey as $value) {
                    if (isset($_POST[$value])) {
                        $newData[$value] = $_POST[$value];
                    }
                }

                $parameters = json_decode($deposit->gatewayCurrency()->gateway_parameter);
                $newData['store_passwd'] = md5($parameters->store_password);

                ksort($newData);

                $hashString = "";
                foreach ($newData as $key => $value) {
                    $hashString .= $key . '=' . $value . '&';
                }

                $hashString = rtrim($hashString, '&');

                if (md5($hashString) == $_POST['verify_sign']) {
                    PaymentController::userDataUpdate($deposit);
                    session()->forget(['sslcommerz_user_id', 'sslcommerz_trx', 'sslcommerz_guard']);
                    $notify[] = ['success', 'Payment captured successfully'];
                    return redirect($deposit->success_url)->withNotify($notify);
                }
            }
        }

        // ✅ Already paid — safe fallback
        if ($deposit->status == Status::PAYMENT_SUCCESS) {
            session()->forget(['sslcommerz_user_id', 'sslcommerz_trx', 'sslcommerz_guard']);
            $notify[] = ['success', 'Payment completed successfully'];
            return redirect($deposit->success_url)->withNotify($notify);
        }

        $notify[] = ['error', 'Invalid request'];
        return redirect($deposit->failed_url)->withNotify($notify);
    }

    /**
     * ✅ Restore user session lost after SSLCommerz cross-site redirect
     */
    private function restoreSession($deposit)
    {
        // Already logged in — nothing to restore
        if (Auth::check() || auth('admin')->check()) {
            return;
        }

        $userId = session('sslcommerz_user_id');
        $guard  = session('sslcommerz_guard', 'web');

        if ($userId) {
            if ($guard === 'admin') {
                $admin = \App\Models\Admin::find($userId);
                if ($admin) {
                    Auth::guard('admin')->login($admin);
                }
            } else {
                $user = User::find($userId);
                if ($user) {
                    Auth::login($user);
                }
            }
            return;
        }

        // ✅ Fallback — restore from deposit's user_id directly
        $user = User::find($deposit->user_id);
        if ($user) {
            Auth::login($user);
        }
    }
}
<?php

namespace App\Http\Controllers\Gateway\SslCommerz;

use App\Constants\Status;
use App\Models\Deposit;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;

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
        $postData['ipn_url']      = route('ipn.' . $alias); // ✅ server-to-server IPN

        $postData['product_name']     = $deposit->product_name;
        $postData['product_category'] = $deposit->product_category;
        $postData['product_profile']  = $deposit->product_profile;

        $postData['shipping_method'] = $deposit->shipping_method ?? 'NO';

        if (auth()->check()) {
            $user = auth()->user();
            $postData['cus_name']    = $user->fullname;
            $postData['cus_email']   = $user->email;
            $postData['cus_phone']   = $user->phone;
            $postData['cus_add1']    = $user->address  ?? '';
            $postData['cus_city']    = $user->city     ?? '';
            $postData['cus_country'] = $user->country  ?? '';
        }

        $postData['emi_option'] = "0";

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

                    // ✅ This now handles everything including order activation
                    PaymentController::userDataUpdate($deposit);

                    $notify[] = ['success', 'Payment captured successfully'];
                    return redirect($deposit->success_url)->withNotify($notify);
                }
            }
        }

        $notify[] = ['error', 'Invalid request'];
        return redirect($deposit->failed_url)->withNotify($notify);
    }
}
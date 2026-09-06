<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SslCommerzPaymentController extends Controller
{
    /**
     * Decide which SSLCOMMERZ URL to use (sandbox or live)
     */
    protected function getGatewayUrl(): string
    {
        // Convert env string safely to boolean
        $isSandbox = filter_var(
            env('SSLCZ_SANDBOX', true),
            FILTER_VALIDATE_BOOLEAN
        );

        return $isSandbox
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';
    }

    /**
     * Initiate Payment
     */
    public function payNow(Request $request)
    {
        $post_data = [];

        /* -----------------------------
         | Store Credentials
         |-----------------------------*/
        $post_data['store_id']     = env('SSLCZ_STORE_ID');
        $post_data['store_passwd'] = env('SSLCZ_STORE_PASSWD');

        /* -----------------------------
         | Payment Information
         |-----------------------------*/
        $post_data['total_amount'] = 1500; // Can be dynamic
        $post_data['currency']     = 'BDT';
        $post_data['tran_id']      = uniqid('TRX_');

        /* -----------------------------
         | Redirect URLs
         |-----------------------------*/
        $post_data['success_url'] = route('payment.success');
        $post_data['fail_url']    = route('payment.fail');
        $post_data['cancel_url']  = route('payment.cancel');

        /* -----------------------------
         | Customer Information
         |-----------------------------*/
        $post_data['cus_name']  = 'Test User';
        $post_data['cus_email'] = 'test@example.com';
        $post_data['cus_add1']  = 'Dhaka';
        $post_data['cus_phone'] = '01700000000';

        /* -----------------------------
         | Shipment Information
         |-----------------------------*/
        $post_data['ship_name'] = 'Advance Travel Tourism';
        $post_data['ship_add1'] = 'Dhaka';

        /* -----------------------------
         | Product Information
         |-----------------------------*/
        $post_data['product_profile']  = 'non-physical-goods';
        $post_data['product_category'] = 'travel';
        $post_data['emi_option']       = 0;

        // Optional values
        $post_data['value_a'] = 'Custom Info 1';

        /* -----------------------------
         | SSLCOMMERZ API Call
         |-----------------------------*/
        $direct_api_url = $this->getGatewayUrl();

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($handle);
        $code    = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $error   = curl_error($handle);

        if ($code === 200 && !$error) {
            curl_close($handle);

            $sslcommerzResponse = json_decode($content, true);

            if (!empty($sslcommerzResponse['GatewayPageURL'])) {

                // Save initial transaction
                DB::table('payments')->insert([
                    'tran_id'    => $post_data['tran_id'],
                    'amount'     => $post_data['total_amount'],
                    'status'     => 'Initiated',
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);

                return redirect()->away(
                    $sslcommerzResponse['GatewayPageURL']
                );
            }

            Log::error('SSLCOMMERZ Invalid Response', [
                'response' => $sslcommerzResponse,
            ]);

            return "JSON Data parsing error from SSLCOMMERZ!";
        }

        Log::error('SSLCOMMERZ Connection Failed', [
            'http_code' => $code,
            'curl_error'=> $error,
        ]);

        curl_close($handle);
        return "FAILED TO CONNECT WITH SSLCOMMERZ API";
    }

    /**
     * Payment Success
     */
    public function success(Request $request)
    {
        DB::table('payments')->insert([
            'tran_id'    => $request->input('tran_id'),
            'amount'     => $request->input('amount'),
            'status'     => 'Success',
            'raw_data'   => json_encode($request->all()),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return "Transaction Successful! Transaction ID: "
            . $request->input('tran_id');
    }

    /**
     * Payment Failed
     */
    public function fail(Request $request)
    {
        DB::table('payments')->insert([
            'tran_id'    => $request->input('tran_id'),
            'amount'     => $request->input('amount'),
            'status'     => 'Failed',
            'raw_data'   => json_encode($request->all()),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return "Transaction Failed!";
    }

    /**
     * Payment Cancelled
     */
    public function cancel(Request $request)
    {
        DB::table('payments')->insert([
            'tran_id'    => $request->input('tran_id'),
            'amount'     => $request->input('amount'),
            'status'     => 'Cancelled',
            'raw_data'   => json_encode($request->all()),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return "Transaction Cancelled!";
    }
}

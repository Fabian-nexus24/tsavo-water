<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaWebhookController extends Controller
{
    /**
     * Handle M-Pesa STK Push Callback
     */
    public function callback(Request $request)
    {
        Log::info('M-PESA Callback Received', $request->all());

        $content = json_decode($request->getContent(), true);

        if (!isset($content['Body']['stkCallback'])) {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
        }

        $callback = $content['Body']['stkCallback'];
        $checkoutRequestId = $callback['CheckoutRequestID'];
        $resultCode = $callback['ResultCode'];

        // Find the payment
        $payment = Payment::where('mpesa_checkout_request_id', $checkoutRequestId)->first();

        if (!$payment) {
            Log::warning('M-PESA Payment record not found for CheckoutRequestID: ' . $checkoutRequestId);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
        }

        if ($resultCode == 0) {
            // Payment Successful
            $callbackMetadata = $callback['CallbackMetadata']['Item'];
            $transactionCode = '';

            foreach ($callbackMetadata as $item) {
                if ($item['Name'] == 'MpesaReceiptNumber') {
                    $transactionCode = $item['Value'];
                }
            }

            $payment->update([
                'status' => 'completed',
                'transaction_code' => $transactionCode,
                'paid_at' => now(),
            ]);

            // Mark order as paid and confirmed
            $order = $payment->order;
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'confirmed'
            ]);

            // TODO: Send SMS using SmsService here

            Log::info('M-PESA Payment Successful. Transaction: ' . $transactionCode);

        } else {
            // Payment Failed or Cancelled
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $callback['ResultDesc'] ?? 'Payment failed',
            ]);

            Log::info('M-PESA Payment Failed: ' . $callback['ResultDesc']);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}

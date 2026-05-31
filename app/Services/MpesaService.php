<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $env;
    private $baseUrl;

    public function __construct()
    {
        $this->consumerKey    = env('MPESA_CONSUMER_KEY', 'your_consumer_key_here');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET', 'your_consumer_secret_here');
        $this->passkey        = env('MPESA_PASSKEY', 'your_passkey_here');
        $this->shortcode      = env('MPESA_SHORTCODE', '174379'); // Sandbox default
        $this->env            = env('MPESA_ENV', 'sandbox');
        
        $this->baseUrl = $this->env === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }

    /**
     * Generate M-Pesa Access Token
     */
    public function getAccessToken()
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials
        ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        Log::error('M-PESA Access Token Error', ['response' => $response->body()]);
        throw new \Exception('Failed to generate M-Pesa access token.');
    }

    /**
     * Initiate STK Push
     */
    public function stkPush($phoneNumber, $amount, $reference)
    {
        $accessToken = $this->getAccessToken();
        
        // Format phone number to 2547XXXXXXXX
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);
        
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
        
        // Ensure amount is an integer
        $amount = (int) ceil($amount);

        $callbackUrl = env('APP_URL') . '/api/mpesa/callback';

        $body = [
            'BusinessShortCode' => $this->shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $formattedPhone,
            'PartyB'            => $this->shortcode,
            'PhoneNumber'       => $formattedPhone,
            'CallBackURL'       => $callbackUrl,
            'AccountReference'  => $reference,
            'TransactionDesc'   => 'Payment for Order ' . $reference
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $body);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('M-PESA STK Push Error', [
            'request'  => $body,
            'response' => $response->body()
        ]);
        throw new \Exception('Failed to initiate STK Push.');
    }

    /**
     * Ensure phone number starts with 254
     */
    private function formatPhoneNumber($phone)
    {
        // Remove spaces, + or - 
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 254
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }
        
        // If starts with 7 or 1, prepend 254
        if (strlen($phone) == 9) {
            $phone = '254' . $phone;
        }

        return $phone;
    }
}

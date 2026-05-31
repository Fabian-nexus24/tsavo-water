<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private $username;
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->username = env('AT_USERNAME', 'sandbox');
        $this->apiKey   = env('AT_API_KEY', 'your_at_api_key_here');
        
        // Use sandbox URL if username is 'sandbox'
        $this->baseUrl = $this->username === 'sandbox'
            ? 'https://api.sandbox.africastalking.com/version1/messaging'
            : 'https://api.africastalking.com/version1/messaging';
    }

    /**
     * Send an SMS via Africa's Talking
     */
    public function send($phoneNumber, $message)
    {
        // Format phone number to +254XXXXXXXXX
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);

        $response = Http::asForm()
            ->withHeaders([
                'Accept' => 'application/json',
                'apiKey' => $this->apiKey,
            ])
            ->post($this->baseUrl, [
                'username' => $this->username,
                'to'       => $formattedPhone,
                'message'  => $message,
            ]);

        if ($response->successful()) {
            return true;
        }

        Log::error('Africa\'s Talking SMS Error', [
            'response' => $response->body(),
            'phone'    => $formattedPhone
        ]);
        
        return false;
    }

    /**
     * Ensure phone number starts with +254
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (str_starts_with($phone, '0')) {
            $phone = '+254' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }
}

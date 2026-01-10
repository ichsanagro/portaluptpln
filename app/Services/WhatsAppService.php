<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = config('services.fonnte.url', 'https://api.fonnte.com/send');
        $this->token = config('services.fonnte.token');
    }

    /**
     * Send WhatsApp message via Fonnte API
     *
     * @param string $phoneNumber Phone number with country code (e.g., 628123456789)
     * @param string $message Message content
     * @return array Response from API
     */
    public function sendMessage(string $phoneNumber, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->asForm()->post($this->apiUrl, [
                'target' => $phoneNumber,
                'message' => $message,
                'countryCode' => '62', // Indonesia country code
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $response->json()
                ]);

                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Failed to send WhatsApp message', [
                'phone' => $phoneNumber,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp service exception', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send notification to multiple recipients
     *
     * @param array $phoneNumbers Array of phone numbers
     * @param string $message Message content
     * @return array Results for each recipient
     */
    public function sendBulkMessage(array $phoneNumbers, string $message): array
    {
        $results = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $results[$phoneNumber] = $this->sendMessage($phoneNumber, $message);
        }

        return $results;
    }

    /**
     * Format phone number to international format
     *
     * @param string $phoneNumber Phone number (e.g., 08123456789 or 628123456789)
     * @return string Formatted phone number (e.g., 628123456789)
     */
    public static function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If starts with 0, replace with 62
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        // If doesn't start with 62, add it
        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        return $phoneNumber;
    }
}

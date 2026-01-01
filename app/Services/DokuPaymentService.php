<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DokuPaymentService
{
    private $clientId;
    private $secretKey;
    private $baseUrl;

    public function __construct()
    {
        //Ambil Kredensial dari .env
        $this->clientId = env('DOKU_CLIENT_ID');
        $this->secretKey = env('DOKU_SECRET_KEY');
        
        // Tentukan URL Sandbox atau Production
        $this->baseUrl = env('DOKU_ENV') === 'production' 
            ? 'https://api.doku.com' 
            : 'https://api-sandbox.doku.com';
    }

    public function generatePaymentLink(Transaction $transaction)
    {
        // 2. Cek apakah Client ID terbaca? (Safety Check)
        if (empty($this->clientId)) {
            throw new \Exception('DOKU_CLIENT_ID tidak terbaca. Coba jalankan: php artisan config:clear');
        }

        // 3. Generate Invoice Number Unik jika belum ada
        if (empty($transaction->invoice_number)) {
            $inv = 'INV-' . time() . '-' . $transaction->id;
            
            // Simpan langsung ke properti dan database tanpa mass assignment (bypass)
            $transaction->invoice_number = $inv;
            $transaction->save(); 
        }

        // 4. Siapkan Body Request
        $body = [
            'order' => [
                'amount' => (int) $transaction->total_amount,
                'invoice_number' => $transaction->invoice_number,
                // Redirect balik ke website Anda setelah bayar
                'callback_url' => route('payment.result', ['id' => $transaction->id]),
            ],
            'payment' => [
                'payment_due_date' => 60 
            ],
            'customer' => [
                'name' => $transaction->user->name ?? 'Guest',
                'email' => $transaction->user->email ?? 'guest@example.com',
            ]
        ];

        // 5. Generate Signature Manual
        $requestId = Str::uuid()->toString();
        $timestamp = gmdate("Y-m-d\TH:i:s\Z"); 
        $targetPath = '/checkout/v1/payment'; 

        $signature = $this->generateSignature($body, $requestId, $timestamp, $targetPath);

        // 6. Kirim Request ke Doku
        $response = Http::withHeaders([
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
        ])->post($this->baseUrl . $targetPath, $body);

        // 7. Cek Response
        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['response']['payment']['url'])) {
                $paymentUrl = $data['response']['payment']['url'];
                $transaction->update(['payment_url' => $paymentUrl]);
                
                return $paymentUrl;
            }
        }

        // Jika gagal, lempar error asli dari Doku agar ketahuan
        throw new \Exception('Gagal Doku: ' . $response->body());
    }

    private function generateSignature($body, $requestId, $timestamp, $targetPath)
    {
        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));

        $stringToSign = "Client-Id:" . $this->clientId . "\n" .
                        "Request-Id:" . $requestId . "\n" .
                        "Request-Timestamp:" . $timestamp . "\n" .
                        "Request-Target:" . $targetPath . "\n" .
                        "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));

        return 'HMACSHA256=' . $signature;
    }
}
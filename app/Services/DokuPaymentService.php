<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class DokuPaymentService
{
    protected string $clientId;
    protected string $secretKey;
    protected string $baseUrl;
    protected string $targetPath = '/checkout/v1/payment';

    public function __construct()
    {
        $config = config('services.doku');

        $this->clientId  = $config['client_id'] ?? '';
        $this->secretKey = $config['secret_key'] ?? '';

        if ($this->clientId === '' || $this->secretKey === '') {
            throw new Exception('Config DOKU belum lengkap');
        }

        $this->baseUrl = ($config['env'] ?? 'sandbox') === 'production'
            ? $config['production_url']
            : $config['sandbox_url'];
    }

    // =======================
    // PUBLIC METHOD
    // =======================
    public function generatePaymentLink(Transaction $transaction): string
    {
        $this->ensureInvoice($transaction);

        // 👉 BODY
        $body = $this->buildBody($transaction);

        // 👉 HEADER DATA
        $requestId = (string) Str::uuid();
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        // 👉 SIGNATURE
        $signature = $this->generateSignature(
            $body,
            $requestId,
            $timestamp
        );

        // 👉 HEADER
        $headers = $this->buildHeaders(
            $requestId,
            $timestamp,
            $signature
        );

        // 👉 REQUEST KE DOKU
        $response = Http::withHeaders($headers)
            ->post($this->baseUrl . $this->targetPath, $body);

        if (!$response->successful()) {
            throw new Exception('DOKU Error: ' . $response->body());
        }

        $paymentUrl = data_get($response->json(), 'response.payment.url');

        if (!$paymentUrl) {
            throw new Exception('Payment URL tidak ditemukan');
        }

        $transaction->update([
            'payment_url' => $paymentUrl
        ]);

        return $paymentUrl;
    }

    // =======================
    // BODY
    // =======================
    protected function buildBody(Transaction $transaction): array
    {
        return [
            'order' => [
                'invoice_number' => $transaction->invoice_number,
                'amount' => (int) $transaction->total_amount,
            ],
            'payment' => [
                'payment_due_date' => 60,
            ],
        ];
    }

    // =======================
    // HEADER
    // =======================
    protected function buildHeaders(
        string $requestId,
        string $timestamp,
        string $signature
    ): array {
        return [
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
            'Content-Type' => 'application/json',
        ];
    }

    // =======================
    // SIGNATURE
    // =======================
    protected function generateSignature(
        array $body,
        string $requestId,
        string $timestamp
    ): string {
        $jsonBody = json_encode($body);
        $digest = base64_encode(hash('sha256', $jsonBody, true));

        $stringToSign =
            "Client-Id:{$this->clientId}\n" .
            "Request-Id:{$requestId}\n" .
            "Request-Timestamp:{$timestamp}\n" .
            "Request-Target:{$this->targetPath}\n" .
            "Digest:{$digest}";

        $signature = base64_encode(
            hash_hmac('sha256', $stringToSign, $this->secretKey, true)
        );

        return 'HMACSHA256=' . $signature;
    }

    protected function ensureInvoice(Transaction $transaction): void
    {
        if ($transaction->invoice_number) return;

        $transaction->invoice_number =
            'INV-' . time() . '-' . $transaction->id;
        $transaction->save();
    }
}

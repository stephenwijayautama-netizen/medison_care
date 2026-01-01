<?php

namespace App\Http\Controllers\Api; // <--- WAJIB ADA \Api

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Doku Webhook Masuk!', $request->all());

        $invoiceNumber = $request->input('order.invoice_number');
        $status = $request->input('transaction.status'); 

        Log::info("Mencari Invoice: $invoiceNumber dengan status $status");

        if ($status === 'SUCCESS') {
            $transaction = Transaction::where('invoice_number', $invoiceNumber)->first();
            
            if ($transaction) {
                $transaction->update(['status' => 'paid']);
                Log::info("Berhasil update transaksi: $invoiceNumber jadi PAID");
                return response()->json(['message' => 'Updated']);
            } else {
                Log::error("Transaksi tidak ditemukan: $invoiceNumber");
                return response()->json(['message' => 'Not Found'], 404);
            }
        }

        return response()->json(['message' => 'Status not SUCCESS']);
    }
}
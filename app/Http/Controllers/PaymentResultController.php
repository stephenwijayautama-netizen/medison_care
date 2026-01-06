<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentResultController extends Controller
{
    /**
     * Halaman hasil pembayaran (return URL dari DOKU)
     */
    public function show(int $transactionId)
    {
        $transaction = Transaction::with([
            'user',
            'detailTransactions',
        ])->findOrFail($transactionId);

        // --- TAMBAHKAN DEFINISI $details ---
        $details = $transaction->detailTransactions; 

        $totalProduct = $transaction->detailTransactions->sum('subtotal');

        $grandTotal = $transaction->total_amount; 
            // + ($transaction->shipping_cost ?? 0); // (Opsional: sesuaikan logic ongkir Anda)

        // --- PASTIKAN NAMA FILE VIEW SESUAI ---
        // Jika file blade Anda bernama 'payment-result.blade.php' di folder resources/views
        return view('payment-result', compact(
            'transaction',
            'details',      // <--- JANGAN LUPA KIRIM INI
            'totalProduct',
            'grandTotal'
        ));
    }
}

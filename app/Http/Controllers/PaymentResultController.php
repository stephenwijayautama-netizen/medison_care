<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentResultController extends Controller
{
    /**
     * Tampilkan halaman hasil pembayaran
     */
    public function show($transactionId)
    {
        // Ambil transaksi + detail + user
        $transaction = Transaction::with([
            'user',
            'detailTransactions'
        ])->findOrFail($transactionId);

        // Hitung total produk
        $totalProduct = $transaction->detailTransactions->sum('subtotal');

        return view('payment-result', [
            'transaction'     => $transaction,
            'details'         => $transaction->detailTransactions,
            'totalProduct'    => $totalProduct,
            'grandTotal'      => $transaction->total_amount + $transaction->shipping_cost,
        ]);
    }
}

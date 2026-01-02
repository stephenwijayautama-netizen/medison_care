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

        $totalProduct = $transaction->detailTransactions->sum('subtotal');

        $grandTotal = $transaction->total_amount
            + ($transaction->shipping_cost ?? 0);

        return view('payment-result', compact(
            'transaction',
            'totalProduct',
            'grandTotal'
        ));
    }
}

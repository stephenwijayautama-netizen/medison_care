<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan Daftar Transaksi
public function index()
{
    // Ambil transaksi milik user yang sedang login (sekarang ID 2)
    $transactions = Transaction::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('order', compact('transactions'));
}

    // Menampilkan Detail Transaksi
    public function show($transactionId)
    {
        // 2. Cari data transaksi secara manual berdasarkan ID
        // Gunakan 'findOrFail' agar jika ID tidak ada, otomatis muncul error 404
        $transaction = Transaction::with('detailTransactions')->findOrFail($transactionId);

        // --- Logika Security (Tetap sama) ---
        // Cek apakah user yang login adalah pemilik transaksi ini
        // (Gunakan optional($transaction->user_id) jika ada kemungkinan guest checkout)
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // --- Logika Perhitungan (Tetap sama) ---
        $details = $transaction->detailTransactions;
        $totalProduct = $details->sum('subtotal');
        $grandTotal = $transaction->total_amount;

        // 3. Return View
        // Pastikan nama view sesuai dengan nama file fisik Anda (misal: resources/views/payment-result.blade.php)
        return view('payment-result', compact('transaction', 'details', 'totalProduct', 'grandTotal'));
    }
}
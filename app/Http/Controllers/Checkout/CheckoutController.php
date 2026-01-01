<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\ShippingRate; // ✅ Wajib Import ini
use App\Services\DokuPaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * HALAMAN UTAMA / PROMO
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $products = Product::query()
            ->where(function($query) {
                $query->where('promo', true)
                      ->orWhereColumn('promo_price', '<', 'price');
            })
            ->where('promo_price', '>', 0)
            ->when($request->category, function($q, $id) {
                return $q->where('category_id', $id);
            })
            ->latest()
            ->get();

        return view('promo', compact('categories', 'products'));
    }

    /**
     * HALAMAN SUSU (PRODUK REGULER)
     */
    public function susu(Request $request)
    {
        $categories = Category::all();
        $products = Product::query();

        if ($request->filled('search')) {
            $products->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $products->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $products->where(function($q) {
            $q->where('promo', false)
              ->orWhere('promo_price', 0)
              ->orWhereColumn('promo_price', '>=', 'price');
        });

        return view('susu', [
            'products'   => $products->latest()->get(),
            'categories' => $categories,
        ]);
    }

    /**
     * SIMPAN DATA KE SESSION (TOMBOL CHECKOUT DARI HALAMAN PRODUK)
     */
    public function store(Request $request)
    {
        // 1. Decode Cart dari JSON string
        $cartData = json_decode($request->cart, true);

        // 2. Validasi
        if (!$cartData || count($cartData) === 0) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong atau belum dipilih.');
        }

        // 3. Simpan ke Session dengan nama key 'cart'
        session(['cart' => $cartData]);

        // 4. Redirect ke halaman konfirmasi
        return redirect()->route('konfirmasi_pembayaran');
    }

    /**
     * HALAMAN KONFIRMASI PEMBAYARAN
     */
    public function konfirmasi()
    {
        // 1. Ambil Data Cart dari Session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('susu')->with('error', 'Keranjang belanja kosong!');
        }

        // 2. Ambil Data Produk berdasarkan ID di cart
        $products = Product::whereIn('id', array_keys($cart))->get();

        // 3. Ambil Data Ongkir dari Database
        $shippingOptions = ShippingRate::all(); 

        // 4. Kirim ke View
        return view('Konfirmasi_Pembayaran', compact('cart', 'products', 'shippingOptions'));
    }

    /**
     * PROSES CHECKOUT FINAL
     * (Nama method disesuaikan menjadi processPayment agar match dengan Route Anda)
     */
    public function processPayment(Request $request)
    {
        // 1. Validasi Input (Pastikan user sudah memilih kurir)
        $request->validate([
            'shipping_service' => 'required',        // Nama Kurir (JNE, dll)
            'shipping_cost'    => 'required|numeric', // Harga Ongkir
        ]);

        // 2. Ambil Session Cart
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('susu')->with('error', 'Keranjang kosong atau sesi habis.');
        }

        // 3. Hitung Ulang Subtotal Barang
        $products = Product::whereIn('id', array_keys($cart))->get();
        $productSubtotal = 0;
        
        foreach ($products as $product) {
            $itemData = $cart[$product->id];
            // Handle quantity baik format array maupun integer langsung
            $qty = (is_array($itemData) && isset($itemData['quantity'])) ? $itemData['quantity'] : (int) $itemData;

            // Cek harga promo vs normal
            $price = ($product->promo_price > 0 && $product->promo_price < $product->price) 
                     ? $product->promo_price 
                     : $product->price;
                     
            $productSubtotal += ($price * $qty);
        }

        // 4. Hitung Grand Total (Barang + Ongkir)
        $shippingCost = (int) $request->shipping_cost;
        $grandTotal = $productSubtotal + $shippingCost;

        // 5. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // A. Simpan Header Transaksi
            $transaction = Transaction::create([
                'user_id'          => Auth::id(),
                'invoice_number'   => 'INV-' . time() . '-' . mt_rand(100, 999),
                'total_amount'     => $grandTotal,      // Total Akhir
                'shipping_cost'    => $shippingCost,    // Simpan Ongkir
                'status'           => 'pending',
                'payment_method'   => 'DOKU',
                'transaction_date' => now(),
                // Opsional: Simpan detail kurir di kolom notes (pastikan kolom notes ada di DB)
                // 'notes' => 'Pengiriman via: ' . $request->shipping_service
            ]);

            // B. Simpan Detail Transaksi
            foreach ($products as $product) {
                $itemData = $cart[$product->id];
                $qty = (is_array($itemData) && isset($itemData['quantity'])) ? $itemData['quantity'] : (int) $itemData;

                $price = ($product->promo_price > 0 && $product->promo_price < $product->price) 
                         ? $product->promo_price 
                         : $product->price;

                DetailTransaction::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $qty,
                    'product_name'   => $product->product_name,
                    'price'          => $price,
                    'subtotal'       => $price * $qty,
                ]);
            }

            // C. Panggil Service DOKU
            $dokuService = new DokuPaymentService();
            // Link pembayaran digenerate berdasarkan total_amount (sudah + ongkir)
            $paymentUrl = $dokuService->generatePaymentLink($transaction);

            // D. Simpan URL Doku ke Database
            $transaction->update(['payment_url' => $paymentUrl]);

            // E. Hapus Session Cart
            session()->forget('cart');

            DB::commit();

            // F. Redirect User ke Halaman Bayar Doku
            return redirect()->away($paymentUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
}
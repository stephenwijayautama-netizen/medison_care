<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center min-h-screen">
    <div class="bg-white w-full max-w-[400px] rounded-3xl shadow-xl p-6">
        <h2 class="text-xl font-bold mb-6 border-b pb-3">Konfirmasi Pesanan</h2>
        
        @php $grandTotal = 0; @endphp
        
        @foreach($products as $product)
            @php 
                // Ambil quantity dari session cart
                $qty = $cart[$product->id]; 

                // LOGIKA KRUSIAL: 
                // Jika promo_price ada dan lebih kecil dari price, gunakan promo_price.
                // Jika tidak (produk susu reguler), gunakan price normal.
                $hargaTampil = ($product->promo_price > 0 && $product->promo_price < $product->price) 
                               ? $product->promo_price 
                               : $product->price;

                $subtotal = $hargaTampil * $qty;
                $grandTotal += $subtotal;
            @endphp

            <div class="flex justify-between mb-4 text-sm border-b border-gray-50 pb-3">
                <div class="flex-1 pr-4">
                    <p class="font-bold text-gray-800">{{ $product->product_name }}</p>
                    <p class="text-gray-500 italic">
                        {{ $qty }}x @ Rp{{ number_format($hargaTampil, 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
            </div>
        @endforeach

        <div class="pt-3 mt-4 flex justify-between items-center">
            <span class="font-bold text-gray-600">Total Bayar</span>
            <span class="font-extrabold text-2xl text-[#009345]">
                Rp{{ number_format($grandTotal, 0, ',', '.') }}
            </span>
        </div>

        <button class="w-full bg-[#009345] hover:bg-green-700 text-white py-4 rounded-2xl mt-8 font-bold text-lg shadow-lg shadow-green-100 transition-all active:scale-95">
            BAYAR SEKARANG
        </button>

        <a href="{{ route('susu') }}" class="block text-center text-gray-400 mt-4 text-sm hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali Belanja
        </a>
    </div>
</body>
</html>
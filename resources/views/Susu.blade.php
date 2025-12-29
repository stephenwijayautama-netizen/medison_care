<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medison Care - Produk Susu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-start min-h-screen py-6 font-sans">

    <div class="relative bg-white w-full max-w-[400px] min-h-screen shadow-xl flex flex-col rounded-3xl overflow-hidden">

        <header class="bg-[#009345] p-3 flex items-center gap-3 shadow-md z-30 rounded-t-3xl sticky top-0">
            <a href="/" class="text-white hover:bg-green-700 p-2 rounded-full transition"><i class="fa-solid fa-arrow-left text-lg"></i></a>
            <div class="flex-1">
                <input type="text" placeholder="Cari susu..." class="w-full rounded-full px-4 py-1.5 text-sm outline-none shadow-inner text-gray-700">
            </div>
            <div class="text-white flex gap-3 pr-2 cursor-pointer relative">
                <i class="fa-solid fa-cart-shopping text-lg"></i>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full border border-green-600">2</span>
            </div>
        </header>

        <div class="bg-white border-b border-gray-100 z-20 sticky top-[60px]">
            <div class="flex gap-2 overflow-x-auto p-3 no-scrollbar w-full">
                {{-- TOMBOL "SEMUA" --}}
                <a href="{{ route('susu.index') }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-bold transition-all border block whitespace-nowrap flex-shrink-0
                   {{ request('category') == '' 
                      ? 'bg-[#009345] text-white border-[#009345] shadow-md' 
                      : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                    Semua
                </a>

                {{-- LOOPING KATEGORI DB --}}
                @foreach($categories as $cat)
                <a href="?category={{ $cat->slug }}" 
                   class="px-4 py-1.5 rounded-full text-xs font-bold transition-all border block whitespace-nowrap flex-shrink-0
                   {{ request('category') == $cat->slug 
                      ? 'bg-[#009345] text-white border-[#009345] shadow-md' 
                      : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-3 no-scrollbar pb-24">

            @php
                // Kita gunakan 'reject' untuk membuang produk yang sedang Promo
                // Jadi sisanya adalah produk biasa & best seller
                $regularProducts = $products->reject(function ($item) {
                    // Logic: Buang jika status promo aktif ATAU punya harga coret
                    return $item->promo || ($item->promo_price > 0 && $item->promo_price < $item->price);
                })
                ->sortByDesc('best_seller') // Urutkan Best seller paling atas
                ->values(); // Reset key array biar rapi
            @endphp


            @if($regularProducts->isNotEmpty())
            <div>
                <div class="flex items-center gap-2 px-1 mb-3">
                    <div class="w-1 h-5 bg-[#009345] rounded-full"></div>
                    <h2 class="font-bold text-gray-800 text-md">Daftar Produk</h2>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($regularProducts as $item)
                        {{-- CARD PRODUK REGULAR --}}
                        <article class="relative flex flex-col bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition duration-200 group">
                            
                            {{-- Badge Best Seller (Hanya muncul jika best seller) --}}
                            @if($item->best_seller)
                            <div class="absolute top-0 right-0 z-10">
                                <span class="bg-yellow-400 text-yellow-900 text-[9px] font-extrabold px-2 py-1 rounded-bl-lg uppercase shadow-sm tracking-wider">
                                    <i class="fa-solid fa-star text-[8px] mr-0.5"></i>Terlaris
                                </span>
                            </div>
                            @endif

                            {{-- Gambar --}}
                            <div class="p-4 h-32 flex items-center justify-center bg-white group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $item->image) }}" class="max-h-full object-contain drop-shadow-sm" onerror="this.src='https://placehold.co/200x200/png?text=No+Image'">
                            </div>

                            {{-- Info --}}
                            <div class="p-3 flex-1 flex flex-col justify-between bg-white relative">
                                <h3 class="text-[11px] font-bold text-gray-700 leading-tight mb-2 line-clamp-2 h-8 uppercase">{{ $item->product_name }}</h3> {{-- Pakai product_name sesuai DB --}}
                                
                                <div class="mb-3">
                                    <span class="text-[#009345] font-bold text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                
                                {{-- Tombol Qty --}}
                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-1 border border-gray-100">
                                    <button onclick="decreaseQty({{ $item->id }})" class="w-6 h-6 flex items-center justify-center bg-white text-gray-500 rounded-md shadow-sm hover:text-red-500 transition font-bold text-md border border-gray-200">-</button>
                                    <span id="qty-{{ $item->id }}" class="text-xs font-bold w-6 text-center text-gray-700">0</span>
                                    <button onclick="increaseQty({{ $item->id }})" class="w-6 h-6 flex items-center justify-center bg-[#009345] text-white rounded-md shadow-sm hover:bg-green-700 transition font-bold text-md">+</button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- EMPTY STATE --}}
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 opacity-60">
                    <i class="fa-solid fa-box-open text-4xl mb-2 text-gray-400"></i>
                    <p class="text-sm text-gray-500">Produk tidak ditemukan.</p>
                </div>
            @endif

        </main>

        <div class="p-4 bg-white border-t border-gray-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] sticky bottom-0 z-40">
            <div class="flex justify-between items-center mb-2 text-xs text-gray-500 px-1">
                <span>Total Item: <b class="text-gray-800" id="total-items">0</b></span>
                <span>Estimasi: <b class="text-[#009345]" id="total-price">Rp 0</b></span>
            </div>
            <a href="#" class="w-full flex items-center justify-center gap-2 bg-[#009345] text-white font-bold py-3 rounded-xl shadow-lg hover:bg-green-700 hover:shadow-xl transition-all duration-200 text-sm">
                Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </div>

    <script>
        const qty = {};
        const prices = {}; // Untuk menyimpan harga produk

        // Ambil data harga dari blade ke JS (Optional, buat update real price)
        @foreach($products as $p)
            prices[{{ $p->id }}] = {{ $p->promo_price ?? $p->price }};
        @endforeach

        function increaseQty(id) {
            if(!qty[id]) qty[id] = 0;
            qty[id]++;
            updateUI(id);
        }

        function decreaseQty(id) {
            if(!qty[id]) qty[id] = 0;
            if(qty[id] > 0) qty[id]--;
            updateUI(id);
        }

        function updateUI(id) {
            const el = document.getElementById(`qty-${id}`);
            if(el) el.innerText = qty[id];
            
            // Hitung Total Item
            const totalItems = Object.values(qty).reduce((a, b) => a + b, 0);
            const totalItemsEl = document.getElementById('total-items');
            if(totalItemsEl) totalItemsEl.innerText = totalItems;

            // Hitung Total Harga (Estimasi)
            let totalPrice = 0;
            for (const [pid, quantity] of Object.entries(qty)) {
                if(prices[pid]) {
                    totalPrice += (prices[pid] * quantity);
                }
            }
            
            const totalPriceEl = document.getElementById('total-price');
            if(totalPriceEl) {
                totalPriceEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
            }
        }
    </script>

</body>
</html>
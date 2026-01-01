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

    <header class="bg-[#009345] p-3 flex items-center gap-3 shadow-md z-30 sticky top-0">
        <a href="/" class="text-white hover:bg-green-700 p-2 rounded-full transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>

        <form method="GET" action="{{ url()->current() }}" class="flex-1">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari susu..."
                   class="w-full rounded-full px-4 py-1.5 text-sm outline-none shadow-inner text-gray-700">
        </form>
    </header>

    <div class="bg-white border-b border-gray-100 z-20 sticky top-[52px]">
        <div class="flex gap-2 overflow-x-auto p-3 no-scrollbar w-full">
            <a href="{{ request()->fullUrlWithoutQuery('category') }}"
               class="px-4 py-1.5 rounded-full text-xs font-bold border whitespace-nowrap
               {{ !request('category') ? 'bg-[#009345] text-white border-[#009345]' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->id]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-bold border whitespace-nowrap
                   {{ request('category') == $cat->id ? 'bg-[#009345] text-white border-[#009345] shadow-md' : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-3 no-scrollbar pb-10">
        @php
            $regularProducts = $products->reject(fn($item) =>
                $item->promo || ($item->promo_price > 0 && $item->promo_price < $item->price)
            )->sortByDesc('best_seller')->values();
        @endphp

        @if($regularProducts->isNotEmpty())
            <div class="grid grid-cols-2 gap-3">
                @foreach($regularProducts as $item)
                    <article class="bg-white rounded-xl border shadow-sm overflow-hidden relative">
                        @if($item->best_seller)
                            <span class="absolute top-0 left-0 bg-yellow-400 text-[9px] font-bold px-2 py-1 rounded-br-lg z-10">
                                ⭐ Terlaris
                            </span>
                        @endif

                        <div class="p-4 h-32 flex items-center justify-center">
                            <img src="{{ $item->image ? Storage::url($item->image) : 'https://placehold.co/200x200' }}" class="max-h-full object-contain">
                        </div>

                        <div class="p-3">
                            <h3 class="text-[11px] font-bold uppercase mb-2 line-clamp-2">{{ $item->product_name }}</h3>
                            <p class="text-[#009345] font-bold text-sm mb-3">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                            <div class="flex justify-between items-center bg-gray-50 rounded-lg p-1 border">
                                <button onclick="decreaseQty({{ $item->id }})" class="w-8 h-8 flex items-center justify-center bg-white border rounded shadow-sm hover:bg-gray-100">-</button>
                                <span id="qty-{{ $item->id }}" class="text-sm font-bold">0</span>
                                <button onclick="increaseQty({{ $item->id }})" class="w-8 h-8 flex items-center justify-center bg-[#009345] text-white rounded shadow-sm hover:bg-green-700">+</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 text-gray-400">Produk tidak ditemukan</div>
        @endif
    </main>

    <div class="bg-white border-t p-4 z-40 rounded-t-3xl shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
        <div class="flex justify-between text-xs mb-3 px-1">
            <span class="text-gray-500">Total Item: <b id="total-items" class="text-black">0</b></span>
            <span class="text-gray-500">Total: <b id="total-price" class="text-[#009345] text-sm">Rp 0</b></span>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="form-checkout">
            @csrf
            <input type="hidden" name="cart" id="cart-input">
            <button type="button" onclick="kirimKeServer()" 
                class="w-full bg-[#009345] text-white py-3.5 rounded-2xl font-bold shadow-lg shadow-green-100 active:scale-95 transition-all">
                Lanjut ke Pembayaran
            </button>
        </form>
    </div>

</div>

<script>
    // Inisialisasi data
    const selectedItems = {};
    const prices = {};

    // Mapping harga dari Laravel ke JS
    @foreach($products as $p)
        prices[{{ $p->id }}] = {{ $p->promo_price > 0 && $p->promo_price < $p->price ? $p->promo_price : $p->price }};
    @endforeach

    function increaseQty(id) {
        selectedItems[id] = (selectedItems[id] || 0) + 1;
        updateUI(id);
    }

    function decreaseQty(id) {
        if (selectedItems[id] > 0) {
            selectedItems[id]--;
            updateUI(id);
        }
    }

    function updateUI(id) {
        // Update angka di card produk
        const qtyLabel = document.getElementById(`qty-${id}`);
        if(qtyLabel) qtyLabel.innerText = selectedItems[id];
        
        // Hitung total keseluruhan
        let totalQty = 0;
        let totalPrice = 0;

        for (const key in selectedItems) {
            totalQty += selectedItems[key];
            totalPrice += selectedItems[key] * (prices[key] || 0);
        }

        // Update di footer
        document.getElementById('total-items').innerText = totalQty;
        document.getElementById('total-price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
    }

    function kirimKeServer() {
        const filtered = {};
        let hasItem = false;

        for (const id in selectedItems) {
            if (selectedItems[id] > 0) {
                filtered[id] = selectedItems[id];
                hasItem = true;
            }
        }

        if (!hasItem) {
            alert('Silakan pilih produk terlebih dahulu!');
            return;
        }

        // Masukkan data JSON ke input hidden dan kirim
        document.getElementById('cart-input').value = JSON.stringify(filtered);
        document.getElementById('form-checkout').submit();
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medison Care - Promo Spesial</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-gray-100 flex justify-center min-h-screen py-6 font-sans">

<div class="relative bg-white w-full max-w-[400px] min-h-screen shadow-xl flex flex-col rounded-3xl overflow-hidden">

    <!-- HEADER -->
    <header class="bg-[#009345] p-3 flex items-center gap-3 shadow-md z-30 sticky top-0">
        <a href="/" class="text-white p-2 rounded-full hover:bg-green-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <input type="text" placeholder="Cari promo..."
               class="flex-1 rounded-full px-4 py-1.5 text-sm outline-none">

        <div class="relative text-white">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="absolute -top-2 -right-2 bg-red-500 text-[10px] w-4 h-4 flex items-center justify-center rounded-full">
                2
            </span>
        </div>
    </header>

    <!-- KATEGORI -->
    <div class="bg-white border-b sticky top-[56px] z-20">
        <div class="flex gap-2 overflow-x-auto p-3 no-scrollbar">
            <a href="{{ url()->current() }}"
               class="px-4 py-1.5 rounded-full text-xs font-bold border
               {{ request('category') == '' ? 'bg-[#009345] text-white' : 'bg-gray-50 text-gray-600' }}">
                Semua
            </a>

            @foreach ($categories as $cat)
                <a href="?category={{ $cat->slug }}"
                   class="px-4 py-1.5 rounded-full text-xs font-bold border
                   {{ request('category') == $cat->slug ? 'bg-[#009345] text-white' : 'bg-gray-50 text-gray-600' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- MAIN -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-3 no-scrollbar pb-36">

        @php
            $promoProducts = $products->filter(fn($i) =>
                $i->promo || ($i->promo_price > 0 && $i->promo_price < $i->price)
            );
        @endphp

        <div class="flex items-center gap-2 mb-3 px-1">
            <i class="fa-solid fa-fire text-red-500 animate-pulse"></i>
            <h2 class="font-bold text-gray-800">Daftar Produk Promo</h2>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @forelse($promoProducts as $item)
                <article class="bg-white rounded-xl border shadow-sm overflow-hidden flex flex-col">

                    <!-- IMAGE -->
                    @foreach ($products as $product)
                        <div class="p-4 h-32 flex items-center justify-center">
                            <img src="{{ $product->image ? Storage::url($product->image) : 'https://placehold.co/200x200/png' }}"
                                 class="max-h-full object-contain"
                                 alt="{{ $product->name }}">
                        </div>
                    @endforeach

                    <!-- INFO -->
                    <div class="p-3 flex flex-col gap-1">
                        <h3 class="text-sm font-bold uppercase line-clamp-2">
                            {{ $item->product_name }}
                        </h3>

                        <p class="text-[11px] text-gray-500">
                            {{ Str::limit($product->description, 50) }}
                        </p>

                        <span class="text-[10px] text-gray-400 line-through">
                            Rp {{ number_format($item->price,0,',','.') }}
                        </span>

                        <span class="text-red-600 font-bold text-sm">
                            Rp {{ number_format($item->promo_price,0,',','.') }}
                        </span>
                    </div>

                    <!-- QTY -->
                    <div class="p-2">
                        <div class="flex items-center justify-between bg-red-50 rounded-lg p-1 border">
                            <button onclick="decreaseQty({{ $item->id }})" class="w-6 h-6 bg-white border rounded">-</button>
                            <span id="qty-{{ $item->id }}" class="text-xs font-bold">0</span>
                            <button onclick="increaseQty({{ $item->id }})" class="w-6 h-6 bg-red-500 text-white rounded">+</button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-2 text-center py-20 text-gray-400">
                    Tidak ada promo
                </div>
            @endforelse
        </div>
    </main>

    <!-- FOOTER CHECKOUT (PASTI DI BAWAH) -->
    <div class="sticky bottom-0 w-full bg-white border-t shadow z-40">
        <div class="p-4">
            <div class="flex justify-between text-xs mb-2">
                <span>Total Item: <b id="total-items">0</b></span>
                <span>Estimasi: <b class="text-[#009345]" id="total-price">Rp 0</b></span>
            </div>

            <a href="#"
               class="w-full block text-center bg-[#009345] text-white py-3 rounded-xl font-bold">
                Lanjut ke Pembayaran →
            </a>
        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
    const qty = {};
    const prices = {};

    @foreach ($products as $p)
        prices[{{ $p->id }}] = {{ $p->promo_price ?? $p->price }};
    @endforeach

    function increaseQty(id) {
        qty[id] = (qty[id] || 0) + 1;
        updateUI();
    }

    function decreaseQty(id) {
        if (qty[id] > 0) qty[id]--;
        updateUI();
    }

    function updateUI() {
        let totalItems = 0, totalPrice = 0;

        for (const id in qty) {
            totalItems += qty[id];
            totalPrice += (prices[id] || 0) * qty[id];
            const el = document.getElementById(`qty-${id}`);
            if (el) el.innerText = qty[id];
        }

        document.getElementById('total-items').innerText = totalItems;
        document.getElementById('total-price').innerText =
            'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
    }
</script>

</body>
</html>

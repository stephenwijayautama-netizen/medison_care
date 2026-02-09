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

<body class="bg-gray-100 antialiased min-h-screen font-sans">

<div class="relative bg-white w-full max-w-[450px] min-h-screen shadow-sm flex flex-col overflow-hidden mx-auto">

    <header class="w-full flex items-center justify-between px-2 md:px-6 py-3 bg-white shadow-sm rounded-t-2xl gap-2 md:gap-4 sticky top-0 z-30">
    
        <a href="/" class="flex-shrink-0 w-9 h-9 md:w-10 md:h-10 flex items-center justify-center hover:scale-110 transition-transform -ml-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <form method="GET" action="{{ url()->current() }}" class="flex-1 max-w-[400px]">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="flex items-center w-full gap-2 px-3 py-1.5 bg-[#f9fafb] border border-gray-300 rounded-full focus-within:ring-2 focus-within:ring-green-200 transition-all">
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4 text-gray-400 flex-shrink-0">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="flex-1 min-w-0 bg-transparent text-gray-700 placeholder-gray-400 text-xs md:text-sm focus:outline-none" />

                <button type="submit"
                    class="hidden sm:block px-3 py-1 text-xs font-medium text-white bg-green-600 border border-green-600 rounded-full hover:bg-green-700 transition-colors">
                    Go
                </button>
            </div>
        </form>

        <div class="flex items-center gap-2 md:gap-3 flex-shrink-0 -mr-1">
            <a href="orders" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center hover:scale-110 transition-transform">
                <img src="photo/keranjang.png" alt="Keranjang" class="w-full h-full object-contain">
            </a>

            <a href="profile" class="w-9 h-9 md:w-10 md:h-10 border-2 border-gray-300 rounded-full overflow-hidden flex items-center justify-center hover:border-green-500 hover:scale-110 transition-all">
                <img src="photo/user.png" alt="User" class="w-full h-full object-cover">
            </a>
        </div>
    </header>

    <div class="bg-white border-b border-gray-100 z-20 sticky top-[60px]">
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
                    <div class="bg-white rounded-xl border p-3 relative">
                        @if($item->best_seller)
                            <span class="absolute top-0 left-0 bg-yellow-400 text-[9px] font-bold px-2 py-1 rounded-br-lg z-10">
                                ⭐ Terlaris
                            </span>
                        @endif

                        <img src="{{ $item->image ? Storage::url($item->image) : 'https://placehold.co/200' }}" 
                             class="h-24 mx-auto object-contain">
                        
                        <h3 class="text-xs font-bold mt-2 h-8 line-clamp-2">{{ $item->product_name }}</h3>
                        <p class="text-[#009345] font-bold text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        
                        <div class="flex justify-between items-center mt-2 bg-gray-50 p-1 rounded">
                            <button onclick="decreaseQty({{ $item->id }})" 
                                    class="w-6 h-6 bg-white border rounded hover:bg-gray-100 transition">-</button>
                            <span id="qty-{{ $item->id }}" class="text-xs font-bold">0</span>
                            <button onclick="increaseQty({{ $item->id }})" 
                                    class="w-6 h-6 bg-[#009345] text-white rounded hover:bg-green-700 transition">+</button>
                        </div>
                    </div>
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
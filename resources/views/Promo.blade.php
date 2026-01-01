<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medison Care - Promo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex justify-center min-h-screen py-6">
<div class="bg-white w-full max-w-[400px] min-h-screen shadow-xl rounded-3xl overflow-hidden flex flex-col relative">

    {{-- Header & Kategori tetap sama --}}
    <header class="bg-[#009345] p-3 flex items-center gap-3 shadow-md z-30 sticky top-0">
        <a href="/" class="text-white hover:bg-green-700 p-2 rounded-full transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>

        <form method="GET" action="{{ url()->current() }}" class="flex-1">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari susu..."
                   class="w-full rounded-full px-4 py-1.5 text-sm outline-none shadow-inner text-gray-700">
        </form>
    </header>

    <!-- CATEGORY -->
    <div class="bg-white border-b border-gray-100 z-20 sticky top-[60px]">
        <div class="flex gap-2 overflow-x-auto p-3 no-scrollbar w-full">

            <a href="{{ request()->fullUrlWithoutQuery('category') }}"
               class="px-4 py-1.5 rounded-full text-xs font-bold border whitespace-nowrap
               {{ !request('category')
                   ? 'bg-[#009345] text-white border-[#009345]'
                   : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                Semua
            </a>

            @foreach($categories as $cat)
                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->id]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-bold border whitespace-nowrap
                   {{ request('category') == $cat->id
                       ? 'bg-[#009345] text-white border-[#009345] shadow-md'
                       : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                    {{ $cat->name }}
                </a>
            @endforeach

        </div>
    </div>


    <main class="flex-1 overflow-y-auto p-3 bg-gray-50 pb-28">
        <div class="grid grid-cols-2 gap-3">
            @foreach($products as $item)
                <div class="bg-white rounded-xl border p-3 relative">
                    <img src="{{ $item->image ? Storage::url($item->image) : 'https://placehold.co/200' }}" class="h-24 mx-auto object-contain">
                    <h3 class="text-xs font-bold mt-2 h-8 line-clamp-2">{{ $item->product_name }}</h3>
                    <p class="text-red-600 font-bold text-sm">Rp {{ number_format($item->promo_price,0,',','.') }}</p>
                    
                    <div class="flex justify-between items-center mt-2 bg-gray-50 p-1 rounded">
                        <button onclick="changeQty({{ $item->id }}, -1)" class="w-6 h-6 bg-white border rounded">-</button>
                        <span id="qty-{{ $item->id }}" class="text-xs font-bold">0</span>
                        <button onclick="changeQty({{ $item->id }}, 1)" class="w-6 h-6 bg-[#009345] text-white rounded">+</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    {{-- Footer dengan Form Hidden --}}
    <div class="sticky bottom-0 bg-white border-t p-4 z-40">
        <div class="flex justify-between text-xs mb-2">
            <span>Total Item: <b id="total-items">0</b></span>
            <span>Total: <b id="total-price">Rp 0</b></span>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="form-checkout">
            @csrf
            <input type="hidden" name="cart" id="cart-input">
            <button type="button" onclick="kirimKeServer()" class="w-full bg-[#009345] text-white py-3 rounded-xl font-bold">
                Lanjut ke Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    const selectedItems = {};
    const prices = @json($products->pluck('promo_price', 'id'));

    function changeQty(id, delta) {
        selectedItems[id] = (selectedItems[id] || 0) + delta;
        if (selectedItems[id] < 0) selectedItems[id] = 0;
        updateUI();
    }

    function updateUI() {
        let totalQty = 0; let totalPrice = 0;
        for (const id in selectedItems) {
            totalQty += selectedItems[id];
            totalPrice += selectedItems[id] * (prices[id] || 0);
            document.getElementById(`qty-${id}`).innerText = selectedItems[id];
        }
        document.getElementById('total-items').innerText = totalQty;
        document.getElementById('total-price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
    }

    function kirimKeServer() {
        const filtered = {};
        for(const id in selectedItems) { if(selectedItems[id] > 0) filtered[id] = selectedItems[id]; }
        
        if (Object.keys(filtered).length === 0) return alert('Pilih produk dulu!');
        
        document.getElementById('cart-input').value = JSON.stringify(filtered);
        document.getElementById('form-checkout').submit();
    }
</script>
</body>
</html>
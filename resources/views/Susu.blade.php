<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medison Care - Produk Susu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-start min-h-screen py-6">

    <div class="relative bg-white w-full max-w-[400px] min-h-screen shadow-xl flex flex-col rounded-3xl overflow-hidden">

        <!-- Header -->
        <header class="bg-[#85A35E] p-3 flex items-center gap-3 shadow-md z-50 rounded-t-3xl">
            <a href="/" class="text-white"><i class="fa-solid fa-arrow-left text-lg"></i></a>
            <div class="flex-1">
                <input type="text" placeholder="Cari susu..." class="w-full rounded-full px-3 py-1 text-sm outline-none">
            </div>
            <div class="text-white flex gap-3"><i class="fa-solid fa-cart-shopping"></i></div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-white p-3 no-scrollbar">
            <div class="px-2 py-2 font-bold text-gray-800 text-lg">Daftar Produk Susu</div>

            <div class="grid grid-cols-2 gap-3 pb-20">
                @forelse($products as $item)
                <article class="relative flex flex-col bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition">

                    <!-- Label Terlaris -->
                    @if($item->best_seller)
                    <div class="absolute top-0 right-0 z-10">
                        <span class="bg-[#fdf522] text-[#333] text-[9px] font-bold px-2 py-0.5 rounded-bl-md uppercase">Terlaris</span>
                    </div>
                    @endif

                    <!-- Gambar Produk -->
                    <div class="p-2 h-28 flex items-center justify-center bg-white">
                        <img src="{{ asset('storage/' . $item->image) }}" class="max-h-full object-contain" onerror="this.src='/photo/obat.webp'">
                    </div>

                    <!-- Informasi Produk -->
                    <div class="p-2 flex-1 flex flex-col justify-between border-t border-gray-50">
                        <h3 class="text-[10px] font-bold text-gray-700 h-6 overflow-hidden uppercase mb-1 text-center">{{ $item->name }}</h3>
                        <div class="text-[#009345] font-bold text-[12px] text-center mb-2">
                            Rp {{ number_format($item->price, 0, ',', '.') }},-
                        </div>

                        <!-- Kontrol Jumlah Produk -->
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="decreaseQty({{ $item->id }})" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm font-bold hover:bg-gray-300">-</button>
                            <span id="qty-{{ $item->id }}" class="text-sm font-bold w-6 text-center">0</span>
                            <button onclick="increaseQty({{ $item->id }})" class="bg-[#009345] text-white px-2 py-1 rounded text-sm font-bold hover:bg-green-700">+</button>
                        </div>
                    </div>
                </article>
                @empty
                <p class="col-span-2 text-center py-10 text-gray-400 text-sm">Belum ada produk susu.</p>
                @endforelse
            </div>
        </main>

        <!-- Tombol Checkout -->
        <div class="p-3 bg-white border-t shadow-md sticky bottom-0">
    <a href="#" 
       class="w-full flex items-center justify-center bg-[#85A35E] text-white font-semibold py-2 rounded-full shadow 
              hover:bg-green-600 hover:shadow-lg hover:scale-105 transition transform duration-200 ease-in-out text-sm">
        Lanjut ke Pembayaran
    </a>
</div>


    </div>

    <script>
        const qty = {};

        function increaseQty(id) {
            if(!qty[id]) qty[id] = 0;
            qty[id]++;
            document.getElementById(`qty-${id}`).innerText = qty[id];
        }

        function decreaseQty(id) {
            if(!qty[id]) qty[id] = 0;
            if(qty[id] > 0) qty[id]--;
            document.getElementById(`qty-${id}`).innerText = qty[id];
        }
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</body>
</html>

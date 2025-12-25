<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medison Care - Produk Susu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 flex justify-center items-center min-h-screen">

    <div class="relative bg-white w-full max-w-[450px] h-screen shadow-2xl flex flex-col md:rounded-[40px] md:border-[8px] md:border-gray-900 overflow-hidden">
        
        <header class="bg-[#009345] p-4 flex items-center gap-3 shadow-md z-50">
            <a href="/" class="text-white"><i class="fa-solid fa-arrow-left text-lg"></i></a>
            <div class="flex-1">
                <input type="text" placeholder="Cari susu..." class="w-full rounded-full px-4 py-1.5 text-sm outline-none">
            </div>
            <div class="text-white flex gap-3"><i class="fa-solid fa-cart-shopping"></i></div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-2 no-scrollbar">
            <div class="px-2 py-3 font-bold text-gray-800 text-lg">Daftar Produk Susu</div>
            
            <div class="grid grid-cols-2 gap-2 pb-24">
                @forelse($products as $item)
                <article class="relative flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                    <div class="absolute top-0 right-0 z-10">
                        <span class="bg-[#fdf522] text-[#333] text-[9px] font-bold px-3 py-1 rounded-bl-lg uppercase">Terlaris</span>
                    </div>

                    <div class="p-4 h-40 flex items-center justify-center bg-white">
                        <img src="{{ asset('storage/' . $item->image) }}" class="max-h-full object-contain" onerror="this.src='/photo/obat.webp'">
                    </div>

                    <div class="p-3 text-center flex-1 flex flex-col border-t border-gray-50">
                        <h3 class="text-[11px] font-bold text-gray-700 h-10 overflow-hidden uppercase mb-2">{{ $item->name }}</h3>
                        <div class="mb-3 text-[#009345] font-bold text-[14px]">
                            Rp {{ number_format($item->price, 0, ',', '.') }},-
                        </div>
                        <button class="w-full bg-[#009345] text-white py-2 rounded-lg text-[12px] font-bold flex items-center justify-center gap-2">
                            BELI <i class="fa-solid fa-circle-plus"></i>
                        </button>
                    </div>
                </article>
                @empty
                <p class="col-span-2 text-center py-20 text-gray-400">Belum ada produk susu.</p>
                @endforelse
            </div>
        </main>

        <nav class="bg-white border-t p-3 flex justify-around items-center text-gray-300">
            <i class="fa-solid fa-home text-[#009345] text-xl"></i>
            <i class="fa-solid fa-clipboard-list text-xl"></i>
            <i class="fa-solid fa-user text-xl"></i>
        </nav>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order History</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="mx-auto w-full max-w-md bg-white min-h-screen shadow border-x text-gray-900">

  <header class="sticky top-0 z-10 bg-white px-4 py-4 border-b shadow-sm flex items-center justify-center relative">
    
    <a href="/" class="absolute left-4 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </a>

    <h1 class="font-bold text-lg text-gray-800">Riwayat Pesanan</h1>
  </header>

  <main class="px-4 py-6">
    
    @forelse($transactions as $trx)
        <a href="{{ route('orders.show', $trx->id) }}" class="block mb-4 group">
            <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md hover:border-orange-500 transition duration-200">
                
                <div class="flex justify-between items-center mb-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500 font-medium">No. Pesanan</span>
                        <span class="text-sm font-bold text-gray-800">#{{ $trx->id }}</span>
                    </div>
                    
                    @php
                        $statusColors = [
                            'paid' => 'bg-green-100 text-green-700 border-green-200',
                            'processing' => 'bg-orange-100 text-orange-700 border-orange-200',
                            'failed' => 'bg-red-100 text-red-700 border-red-200',
                            'pending' => 'bg-gray-100 text-gray-600 border-gray-200',
                        ];
                        $currColor = $statusColors[$trx->status] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $currColor }} capitalize">
                        {{ $trx->status }}
                    </span>
                </div>

                <hr class="border-dashed border-gray-200 my-3">

                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Total Belanja</p>
                        <p class="text-base font-bold text-orange-600">
                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400">
                            {{ $trx->transaction_date->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $trx->transaction_date->format('H:i') }} WIB
                        </p>
                    </div>
                </div>

            </div>
        </a>
    @empty
        <div class="flex flex-col items-center justify-center text-center py-16 gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8"/>
            </svg>

            <h2 class="text-gray-700 font-semibold text-lg">Belum ada pesanan</h2>
            <p class="text-gray-500 text-sm">Silakan tambahkan item ke keranjang untuk membuat pesanan.</p>

            <a href="/susu" class="mt-4 px-6 py-2 bg-green-600 text-white rounded-full text-sm font-semibold hover:bg-green-700 transition">
                Belanja Sekarang
            </a>
        </div>
    @endforelse

  </main>
</div>

</body>
</html>
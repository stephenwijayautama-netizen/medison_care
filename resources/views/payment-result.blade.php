<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pembayaran</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F97316',
                        success: '#22C55E'
                    }
                }   
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex justify-center">

    <!-- Mobile Container -->
    <div class="w-full max-w-md bg-white min-h-screen px-5 pt-6 pb-10">

        <!-- Header -->
        <h1 class="text-center text-lg font-semibold mb-6">
            Hasil Pembayaran
        </h1>

        <!-- Status Section -->
        <div class="flex flex-col items-center mb-6">

            <!-- Icon -->
            <div class="w-14 h-14 rounded-full 
                @if($transaction->status === 'paid') bg-success
                @elseif($transaction->status === 'processing') bg-orange-400
                @else bg-gray-400
                @endif
                flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="3"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <p class="text-gray-600 text-sm capitalize">
                {{ $transaction->status }}
            </p>

            <!-- Grand Total -->
            <p class="text-2xl font-bold mt-1">
                Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </p>

            <!-- Badge -->
            <span class="mt-2 px-4 py-1 rounded-full text-sm
                @if($transaction->status === 'paid') bg-green-100 text-green-600
                @elseif($transaction->status === 'processing') bg-orange-100 text-orange-600
                @else bg-gray-100 text-gray-600
                @endif">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>

        <!-- Detail Transaction -->
        <div class="bg-gray-50 rounded-xl p-4 space-y-4 text-sm">

            <!-- Produk -->
            <div class="flex justify-between items-start">
                <span class="text-gray-500">Produk</span>
                <div class="text-right space-y-1">
                    @foreach ($details as $item)
                        <div>
                            <p class="font-semibold">
                                {{ $item->product_name }} x{{ $item->quantity }}
                            </p>
                            <p class="text-gray-400 text-xs">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Subtotal Produk -->
            <div class="flex justify-between">
                <span class="text-gray-500">Subtotal Produk</span>
                <span class="font-semibold">
                    Rp {{ number_format($totalProduct, 0, ',', '.') }}
                </span>
            </div>

            <!-- Ongkir -->
            <div class="flex justify-between">
                <span class="text-gray-500">Biaya Pengiriman</span>
                <span class="font-semibold">
                    Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}
                </span>
            </div>

            <!-- Total -->
            <div class="flex justify-between">
                <span class="text-gray-500">Jumlah Total</span>
                <span class="font-semibold">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </span>
            </div>

            <!-- Metode Pembayaran -->
            <div class="flex justify-between">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-semibold capitalize">
                    {{ str_replace('_', ' ', $transaction->payment_method) }}
                </span>
            </div>

            <!-- User -->
            <div class="flex justify-between">
                <span class="text-gray-500">Pembeli</span>
                <span class="font-semibold">
                    {{ $transaction->user->name }}
                </span>
            </div>

            <!-- Transaction ID -->
            <div class="flex justify-between">
                <span class="text-gray-500">ID Transaksi</span>
                <span class="text-gray-700">
                    #{{ $transaction->id }}
                </span>
            </div>

            <!-- Waktu -->
            <div class="flex justify-between">
                <span class="text-gray-500">Waktu Transaksi</span>
                <span class="text-gray-700">
                    {{ $transaction->transaction_date->format('d M Y, H:i') }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 space-y-3">
            <button
                onclick="navigator.share && navigator.share({
                    title: 'Struk Pembayaran',
                    text: 'Transaksi #{{ $transaction->id }} sebesar Rp {{ number_format($grandTotal, 0, ',', '.') }}'
                })"
                class="w-full border border-primary text-primary py-3 rounded-xl font-semibold">
                Bagikan
            </button>

            <a href="/"
               class="block text-center w-full bg-primary text-white py-3 rounded-xl font-semibold">
                OK
            </a>
        </div>

    </div>

</body>
</html>

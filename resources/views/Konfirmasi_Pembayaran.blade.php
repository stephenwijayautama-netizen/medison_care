<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6 flex justify-center items-center min-h-screen">
    <div class="bg-white w-full max-w-[450px] rounded-3xl shadow-xl p-6">
        <h2 class="text-xl font-bold mb-6 border-b pb-3">Konfirmasi Pesanan</h2>
        
        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            @php $subtotalBarang = 0; @endphp
            
            <div class="max-h-60 overflow-y-auto mb-4 pr-2">
                @foreach($products as $product)
                    @php 
                        $qty = $cart[$product->id]; 
                        $hargaTampil = ($product->promo_price > 0 && $product->promo_price < $product->price) 
                                        ? $product->promo_price 
                                        : $product->price;

                        $subtotal = $hargaTampil * $qty;
                        $subtotalBarang += $subtotal;
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
            </div>

            <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="font-bold text-gray-700 mb-3 text-sm">
                    <i class="fa-solid fa-truck mr-2"></i>Pilih Pengiriman
                </h3>
                <div class="space-y-3">
                    @foreach($shippingOptions as $option)
                        <label class="flex items-center justify-between p-3 bg-white border rounded-lg cursor-pointer hover:border-green-500 transition-all">
                            <div class="flex items-center">
                                <input type="radio" 
                                    name="shipping_service" 
                                    value="{{ $option->name }}" 
                                    data-cost="{{ $option->cost }}" 
                                    class="shipping-option w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300" 
                                    required>
                                    
                                <div class="ml-3">
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $option->name }}
                                    </span>
                                    <span class="block text-xs text-gray-500">
                                        {{ $option->description ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-700">
                                Rp {{ number_format($option->cost, 0, ',', '.') }}
                            </span>
                        </label>
                    @endforeach
                </div>

            <div class="space-y-2 border-t pt-4">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal Barang</span>
                    <span>Rp{{ number_format($subtotalBarang, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Ongkos Kirim</span>
                    <span id="display-ongkir">Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-2 mt-2 border-t border-dashed">
                    <span class="font-bold text-gray-800 text-lg">Total Bayar</span>
                    <span class="font-extrabold text-2xl text-[#009345]" id="display-grand-total">
                        Rp{{ number_format($subtotalBarang, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <input type="hidden" name="shipping_cost" id="input-shipping-cost" value="0">
            <input type="hidden" name="grand_total" id="input-grand-total" value="{{ $subtotalBarang }}">

            <button type="submit" id="btn-bayar" disabled class="mt-6 w-full font-bold text-white py-4 rounded-xl shadow-lg transition-all duration-200 bg-gray-400 cursor-not-allowed">
                PILIH PENGIRIMAN DULU
            </button>
        </form>

        <a href="{{ route('susu') }}" class="block text-center text-gray-400 mt-4 text-sm hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali Belanja
        </a>
    </div>

    @if(session('error'))
        <div class="fixed top-5 right-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('.shipping-option');
            const displayOngkir = document.getElementById('display-ongkir');
            const displayGrandTotal = document.getElementById('display-grand-total');
            const inputShippingCost = document.getElementById('input-shipping-cost');
            const inputGrandTotal = document.getElementById('input-grand-total');
            const btnBayar = document.getElementById('btn-bayar');

            // Ambil subtotal barang dari PHP (blade)
            const subtotalBarang = {{ $subtotalBarang }};

            // Format angka ke Rupiah
            const formatRupiah = (number) => {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            };

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // 1. Ambil harga ongkir dari atribut data-cost
                    const shippingCost = parseInt(this.getAttribute('data-cost'));
                    
                    // 2. Hitung Total Baru
                    const newGrandTotal = subtotalBarang + shippingCost;

                    // 3. Update Tampilan UI
                    displayOngkir.textContent = formatRupiah(shippingCost);
                    displayGrandTotal.textContent = formatRupiah(newGrandTotal);

                    // 4. Update Nilai Input Hidden (untuk dikirim ke Backend)
                    inputShippingCost.value = shippingCost;
                    inputGrandTotal.value = newGrandTotal;

                    // 5. Aktifkan Tombol Bayar
                    btnBayar.disabled = false;
                    btnBayar.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    btnBayar.classList.add('bg-[#00994A]', 'hover:bg-green-700');
                    btnBayar.textContent = 'BAYAR SEKARANG';
                });
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order</title>
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
</head>
<body class="bg-gray-50">

<div class="mx-auto w-full max-w-md bg-white rounded-2xl shadow border text-gray-900 mt-10">

  <!-- Header -->
  <header class="px-4 py-3 border-b text-center">
    <h1 class="font-semibold text-lg">Medison</h1>
  </header>

  <!-- Main Content -->
  <main class="px-4 py-6">
    <div class="flex flex-col items-center justify-center text-center py-16 gap-4">

      <!-- Ilustrasi Kosong -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8"/>
      </svg>

      <!-- Pesan Kosong -->
      <h2 class="text-gray-700 font-semibold text-lg">Belum ada pesanan</h2>
      <p class="text-gray-500 text-sm">Silakan tambahkan item ke keranjang untuk membuat pesanan.</p>

      <!-- Tombol Tambah Pesanan -->
      <a href="/susu" class="mt-4 px-6 py-2 bg-green-600 text-white rounded-full text-sm font-semibold hover:bg-green-700 transition">
        Tambah Pesanan
      </a>

    </div>
  </main>

</div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Medison Care') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])

</head>

<body class="antialiased aspect-9-16 "
  style="--frame: 520px;">

 <header class="w-full flex items-center gap-2 px-1 py-3">
  <!-- Kiri: Logo -->
  <div class="w-[100px] flex-shrink-0">
    <img src="photo/logo.png" alt="">
  </div>

  <!-- Tengah: Search (ketengah) -->
  <form
    action="#"
    method="GET"
    class="flex-1 min-w-0 flex justify-center"
  >
    <div class="flex items-center gap-2 bg-[#f9fafb] border border-gray-300 rounded-full px-4 py-1.5 w-full max-w-[380px] shadow-sm focus-within:ring-2 focus-within:ring-gray-200 transition-all duration-300">
      <!-- Ikon Search -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round"
        class="w-4 h-4 text-gray-500 flex-shrink-0">
        <circle cx="11" cy="11" r="7" />
        <line x1="21" y1="21" x2="16.65" y2="16.65" />
      </svg>

      <!-- Input -->
      <input
        type="text"
        name="search"
        placeholder="Search anything..."
        class="min-w-0 flex-1 bg-transparent text-gray-700 placeholder-gray-400 text-[14px] focus:outline-none"
      />

      <!-- Tombol -->
      <button
        type="submit"
        class="px-3 py-1 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-full hover:bg-gray-100 transition-colors duration-300"
      >
        Go
      </button>
    </div>
  </form>

  <!-- Kanan: Icon -->
  <div class="flex items-center gap-3 flex-shrink-0">
    <a href="/views/order">
      <img src="photo/keranjang.png" alt="" class="w-[50px]">
    </a>

   <div class="w-[22px] -ml-1 mt-1">
  <a href="profile">
    <img src="photo/user.png" alt="">
  </a>
</div>

  </div>
</header>

      <!-- 🖼️ Slider Container -->
      <div class="relative w-full overflow-hidden rounded-2xl shadow-2xl mt-[-10px]">
        <!-- Tips: jika nanti pakai slider JS, tambahkan width dinamis per slide -->
        <div class="slides flex transition-transform duration-700">
          <img
            src="https://goalkes-images.s3.ap-southeast-1.amazonaws.com/media/8587/hDwQMwUmOSbso6VlQ2c7ihQnxrWYeCSGQEbP0gBB.jpg"
            class="w-full h-64 md:h-72 object-cover flex-shrink-0"
            alt="Healthcare banner 1"
          >
          <img
            src="https://goalkes-images.s3.ap-southeast-1.amazonaws.com/media/8587/hDwQMwUmOSbso6VlQ2c7ihQnxrWYeCSGQEbP0gBB.jpg"
            class="w-full h-64 md:h-72 object-cover flex-shrink-0"
            alt="Healthcare banner 2"
          >
          <img
            src="https://goalkes-images.s3.ap-southeast-1.amazonaws.com/media/8587/hDwQMwUmOSbso6VlQ2c7ihQnxrWYeCSGQEbP0gBB.jpg"
            class="w-full h-64 md:h-72 object-cover flex-shrink-0"
            alt="Healthcare banner 3"
          >
        </div>
      </div>

  <section class="mt-6">
  <div class="flex flex-row justify-center items-start gap-3 px-2">
    
    <a href="#konsultasi" class="flex flex-col items-center rounded-2xl p-2 transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-1 group w-20">
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute w-12 h-12 bg-green-50 rounded-full transition-all duration-300 group-hover:scale-125 group-hover:bg-green-100 -z-10"></div>
            <div class="transition-transform duration-500 ease-out group-hover:scale-110">
                <creattie-embed
                    src="https://d1jj76g3lut4fe.cloudfront.net/saved_colors/138670/Rs2QWShtIpZW2AEA.json"
                    delay="1" speed="100" frame_rate="24" trigger="loop"
                    style="width:50px; height:50px;">
                </creattie-embed>
                <script src="https://creattie.com/js/embed.js?id=3efa1fcb5d85991e845a" defer></script>
            </div>
        </div>
        <p class="mt-2 text-[10px] font-bold text-gray-700 text-center uppercase tracking-wide leading-tight transition-colors duration-300 group-hover:text-[#009345]">
            Konsultasi<br>Dokter
        </p>
    </a>

    <a href="views/unggah_file" class="flex flex-col items-center rounded-2xl p-2 transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-1 group w-20">
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute w-12 h-12 bg-green-50 rounded-full transition-all duration-300 group-hover:scale-125 group-hover:bg-green-100 -z-10"></div>
            <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.11/dist/dotlottie-wc.js" type="module"></script>
            <div class="transition-transform duration-500 ease-out group-hover:scale-110">
                <dotlottie-wc 
                    src="https://lottie.host/03f5de38-2071-4aaa-9122-b14b6836504a/5WtpbhaU5i.lottie" 
                    style="width: 50px; height: 50px" 
                    autoplay 
                    loop>
                </dotlottie-wc>
            </div>
        </div>
        <p class="mt-2 text-[10px] font-bold text-gray-700 text-center uppercase tracking-wide transition-colors duration-300 group-hover:text-[#009345]">
            Unggah Resep
        </p>
    </a>

    <a href="views/Susu" class="flex flex-col items-center rounded-2xl p-2 transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-1 group w-20">
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute w-12 h-12 bg-green-50 rounded-full transition-all duration-300 group-hover:scale-125 group-hover:bg-green-100 -z-10"></div>
            <div class="transition-transform duration-500 ease-out group-hover:scale-110 group-hover:rotate-3">
                <dotlottie-wc 
                    src="https://lottie.host/f449adbe-e726-46b6-9fc0-10f32bd02009/hek9neDcKR.lottie" 
                    style="width: 50px; height: 50px" 
                    autoplay 
                    loop>
                </dotlottie-wc>
            </div>
        </div>
        <p class="mt-2 text-[10px] font-bold text-gray-700 text-center uppercase tracking-wide transition-colors duration-300 group-hover:text-[#009345]">
            Susu
        </p>
    </a>

    <a href="#promo" class="flex flex-col items-center rounded-2xl p-2 transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-1 group w-20">
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute w-12 h-12 bg-green-50 rounded-full transition-all duration-300 group-hover:scale-125 group-hover:bg-[#009345]/10 -z-10"></div>
            <div class="transition-transform duration-500 ease-out group-hover:scale-110 group-hover:-rotate-3">
                <dotlottie-wc 
                    src="https://lottie.host/9b921e8e-63b7-4479-b680-4e47696b23a5/QKP2wSNTSD.lottie" 
                    style="width: 50px; height: 50px" 
                    autoplay 
                    loop>
                </dotlottie-wc>
            </div>
        </div>
        <p class="mt-2 text-[10px] font-bold text-gray-700 text-center uppercase tracking-wide transition-colors duration-300 group-hover:text-[#009345]">
            Promo
        </p>
    </a>

  </div>
</section>
<section>
    <div>
      <img src="photo/banner3.png" alt="" class=" w-[400px] h-[250px] rounded-xl ml-[60px] mt-[20px]">
    </div>
</section>

<!-- PROMO SECTION -->
<section class="mt-6 font-[inter]">
  <div class="flex items-center justify-between mb-3 px-3">
    <h2 class="text-[17px] font-semibold text-gray-800">Promo</h2>
    <a href="#semua-promo" class="text-[13px] text-green-600 hover:underline font-medium">
      lihat semua &gt;
    </a>
  </div>

  <!-- SCROLL LIST -->
  <div class="overflow-x-auto snap-x snap-mandatory [-ms-overflow-style:none] [scrollbar-width:none] px-2">
    <div class="flex gap-3 min-w-max [&>*]:snap-start pb-1">
      
      @forelse($products as $product)
        <!-- CARD DYNAMIC -->
        <article class="relative w-40 bg-white rounded-xl border border-green-300 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
          <!-- Badge PROMO -->
          <div class="absolute top-0 left-0 w-full flex justify-center pointer-events-none">
            <span class="inline-block bg-[#C6A252] text-white text-[10px] font-semibold px-2 py-1 rounded-b-md shadow-sm uppercase tracking-wide">
              Promo
            </span>
          </div>

          <div class="p-2 pt-5">
            <!-- Gambar -->
            <div class="h-20 flex items-center justify-center mb-2">
              <img src="{{ asset('storage/products/' . $product->image) }}" 
                   alt="{{ $product->name }}" 
                   class="max-h-16 object-contain"
                   onerror="this.src='/photo/obat.webp'">
            </div>

            <!-- Judul -->
            <h3 class="text-[11px] font-semibold text-gray-900 text-center leading-snug uppercase line-clamp-2">
              {{ Str::upper($product->name) }}
            </h3>

            <!-- Harga -->
            <div class="mt-1 text-center">
              @if($product->old_price)
                <div class="text-[10px] text-red-500 line-through">Rp {{ number_format($product->old_price, 0, ',', '.') }}</div>
              @endif
              <div class="text-[12px] text-green-600 font-extrabold">
                Rp {{ number_format($product->price, 0, ',', '.') }},- 
                <span class="text-gray-600 font-medium text-[10px]">/ {{ $product->unit ?? 'Pcs' }}</span>
              </div>
              <div class="text-[10px] text-gray-500 mt-[2px]">13.4 RB+ Terjual</div>
            </div>
          </div>
        </article>
      @empty
        <p class="text-center text-gray-500 py-8 w-full">Belum ada produk promo</p>
      @endforelse

    </div>
  </div>
</section>


    <!-- 🤝 Supported brand -->

<section class="font-[inter] mt-[40px] mb-[40px]">
  <div class="text-center">

    <p class="font-bold text-[26px] text-gray-800 mb-6 tracking-wide">
      Our Supported Brands
    </p>

    <div class="flex flex-wrap justify-center gap-6">
      @forelse($brands as $brand)
        <div class="bg-gradient-to-b from-white to-[#f4f7f4] p-4 rounded-2xl shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2 hover:scale-105">
          <img 
            src="{{ Storage::disk('public')->url('brands/' . $brand->image) }}" 
            alt="{{ $brand->name }}" 
            class="w-[90px] h-auto object-contain"
          >
        </div>
      @empty
        <p class="text-gray-500">Belum ada brand yang ditambahkan</p>
      @endforelse
    </div>

  </div>
</section>


<section class="font-[inter] mt-[50px] mb-[50px]">
  <div class="container mx-auto text-center">
    <p class="font-bold text-[24px] text-gray-800 mb-8 tracking-wide">
      What’s New
    </p>

    <div class="flex flex-wrap justify-center gap-6">

      @forelse($news as $item)
        <div class="bg-white border border-gray-100 rounded-2xl shadow-md w-[140px] h-[200px] flex flex-col transition-all duration-500 hover:shadow-xl hover:-translate-y-1 overflow-hidden">
          
          <div class="p-2 h-[90px]">
            <img
              {{-- Path disesuaikan dengan folder News-images di screenshot --}}
              src="{{ asset('storage/News-images/' . $item->image) }}" 
              alt="{{ $item->title }}" 
              class="rounded-xl w-full h-full object-cover shadow-sm"
              {{-- Fallback jika gambar gagal dimuat --}}
              onerror="this.src='https://placehold.co/400x300?text=No+Image'">
          </div>
        
          <div class="px-3 text-left flex-1 flex flex-col">
            <h3 class="font-semibold text-[12px] text-[#166534] mb-0.5 leading-tight">
              {{ Str::limit($item->title, 20) }}
            </h3>
            
            <p class="text-[10px] text-gray-600 leading-tight mt-1">
              {{ Str::limit($item->description, 35) }}
            </p>
          </div>

          <a href="#" class="block">
            <div class="bg-gradient-to-r from-[#65a30d] to-[#4d7c0f] py-1.5 text-white text-[11px] font-semibold text-center hover:opacity-90 transition">
              Read More
            </div>
          </a>

        </div>
      @empty
        <p class="text-gray-500 text-sm italic">Belum ada berita terbaru.</p>
      @endforelse

    </div>
  </div>
</section>

<section>
  <div class="fixed bottom-20 right-6 z-50">
    <!-- Tombol Chat WhatsApp -->
    <button id="chatButton"
      class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 hover:scale-110 transition-all duration-300">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="w-6 h-6">
    </button>

    <!-- Popup Chat -->
    <div id="chatPopup"
      class="hidden absolute bottom-20 right-2 w-[300px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden animate-fade-in">
      
      <!-- Header -->
      <div class="flex items-center gap-3 p-4 bg-green-500 text-white rounded-t-2xl">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA"
          class="w- h-8 bg-white rounded-full p-1">
        <div>
          <p class="font-semibold text-sm leading-tight">Medison Care Support</p>
          <p class="text-xs opacity-90">Online • Usually replies within minutes</p>
        </div>
      </div>

      <script type="module">
    import Chatbot from "https://cdn.jsdelivr.net/npm/flowise-embed/dist/web.js"
    Chatbot.init({
        chatflowid: "33346acb-60a5-412f-88ba-3684627baf7b",
        apiHost: "https://cloud.flowiseai.com",
    })
</script>

      <!-- Isi Pesan -->
      <div class="p-4 text-gray-700 text-sm bg-gray-50">
        <div class="mb-3 bg-white p-3 rounded-lg shadow-sm border border-gray-100">
          👋 Halo! Ada yang bisa kami bantu hari ini?
        </div>
        <a href="https://wa.me/6281222200640" target="_blank"
          class="flex items-center justify-center gap-2 bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition font-medium text-sm shadow-md hover:shadow-lg">
          <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA" class="w-4 h-4">
          Chat via WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ANIMASI & SCRIPT -->
<style>
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fadeInUp 0.3s ease forwards;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById('chatButton');
    const popup = document.getElementById('chatPopup');

    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      popup.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!btn.contains(e.target) && !popup.contains(e.target)) {
        popup.classList.add('hidden');
      }
    });
  });
</script>

      <!-- ⚙️ Footer -->
      <footer class="bg-[#85A35E] text-white mt-6 rounded-2xl overflow-hidden">

        <!-- Bottom -->
        <div class="border-t border-white/20 py-3 text-center text-xs">
          © 2025 Medison Care. All rights reserved.
        </div>
      </footer>

    </div> <!-- /wrapper -->
  </div> <!-- /aspect-9-16 -->
</body>
</html>

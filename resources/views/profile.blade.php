<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Medison Care') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-[#F6F8F5] font-sans">
  <div class="aspect-9-16 max-w-md mx-auto shadow-xl  h-auto rounded-3xl overflow-hidden border border-gray-100">
    
    <!-- Header -->
    <div class="relative bg-[#7BAE7F] text-center py-7 rounded-b-3xl shadow-lg">
      <a href="javascript:void(0)" onclick="window.location.href='/'"
         class="absolute top-6 left-6 z-10 p-2 bg-white/30 backdrop-blur-md rounded-full hover:bg-white/50 transition"
         aria-label="Kembali">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <p class="text-white text-[25px] font-bold font-[inter] mt-[-8px]">
            My Profile
        </p>
      </div>
      
    <div class="font-[inter] ml-[20px] relative">
  <!-- Foto Profil -->
  <div class="relative inline-block">
    <img 
      id="profileImage"
      src="https://randomuser.me/api/portraits/men/32.jpg" 
      alt="Profile Avatar"
      class="w-[120px] h-[120px] rounded-full ml-[40px] mt-[50px] bg-gray-300 border-4 border-white shadow-lg object-cover"
    >

    <!-- Tombol Kamera -->
    <label for="fileInput"
      class="absolute bottom-0 left-[130px] bg-[#7BAE7F] p-2 rounded-full shadow-md cursor-pointer hover:bg-[#6ca571] transition-all duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2-3h6l2 3h4v13H3V7z" />
        <circle cx="12" cy="13" r="4" />
      </svg>
    </label>

    <!-- Input File (hidden) -->
    <input id="fileInput" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">
  </div>

  <!-- Nama & Info -->
  <p class="text-black text-xl font-semibold mt-[-105px] ml-[190px]">Budi Siregar</p>
  <p class="text-black text-sm italic ml-[192px] font-light">Member since 2023</p>

  <!-- Tombol Ganti Profil -->
  <a href="/views/change_profile">
    <button class="bg-[#7BAE7F] w-[130px] h-[35px] rounded-xl ml-[190px] mt-[10px] hover:bg-[#6ca571] transition">
      <p class="text-[15px] text-white font-medium font-[inter]">Change Profile</p>
    </button>
  </a>
</div>

<!-- Script Preview Foto -->
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
      const output = document.getElementById('profileImage');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
<section class="font-[inter] w-full flex justify-center py-10">
  <div class="w-[340px] relative">

    <!-- MENU LIST -->
    <ul id="menuList" class="space-y-2">

      <!-- Profile -->
      <li id="profileButton"
          class="relative flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-xl transition cursor-pointer">
        <div class="flex items-center gap-3">
          <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
               class="w-6 h-6 object-contain" alt="profile" />
          <span class="text-gray-800 font-medium text-[15px]">Profile</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 text-gray-400 transition-transform duration-200"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" id="arrowIcon">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5l7 7-7 7" />
        </svg>

        <!-- DROPDOWN PROFIL -->
        <div id="profileDropdown"
             class="absolute left-0 top-full mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 hidden transition-all duration-300">
          <ul class="py-2 text-sm text-gray-700">
            <li class="flex justify-between items-center py-1">
              <span class="font-medium text-gray-500">Nama</span>
              <span class="text-[#6ca571] font-semibold">Budi Siregar</span>
            </li>
            <li class="flex justify-between items-center py-1">
              <span class="font-medium text-gray-500">No. Telepon</span>
              <span class="text-[#6ca571] font-semibold">0812-3456-7890</span>
            </li>
            <li class="flex justify-between items-center py-1">
              <span class="font-medium text-gray-500">Tanggal Lahir</span>
              <span class="text-[#6ca571] font-semibold">12 Agustus 1995</span>
            </li>
            <li class="flex justify-between items-center py-1">
              <span class="font-medium text-gray-500">Alamat</span>
              <span class="text-[#6ca571] font-semibold">Jl. Melati No. 21, Jakarta</span>
            </li>
            <li class="flex flex-col py-2 border-t border-gray-100">
              <span class="font-medium text-gray-500 mb-1">Riwayat Penyakit</span>
              <ul class="list-disc list-inside text-[#6ca571] space-y-1">
                <li>Hipertensi</li>
                <li>Alergi Paracetamol</li>
                <li>Gastritis (Maag)</li>
              </ul>
            </li>
          </ul>
        </div>
      </li>

      <!-- Change Password -->
      <a href="/views/change_password">   
      <li class="flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-xl transition cursor-pointer">
        <div class="flex items-center gap-3">
          <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png"
               class="w-6 h-6 object-contain" alt="password" />
          <span class="text-gray-800 font-medium text-[15px]">Change Password</span>
        </div>
      </li></a>
   

      <!-- Location -->
      <li id="locationButton"
          class="flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-xl transition cursor-pointer">
        <div class="flex items-center gap-3">
          <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png"
               class="w-6 h-6 object-contain" alt="location" />
          <span class="text-gray-800 font-medium text-[15px]">Location</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 text-gray-400"
             fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5l7 7-7 7" />
        </svg>
      </li>

      <!-- Logout -->
      <li class="flex items-center justify-between px-3 py-3 hover:bg-red-50 rounded-xl transition cursor-pointer group">
        <div class="flex items-center gap-3">
          <img src="https://cdn-icons-png.flaticon.com/512/1828/1828490.png"
               class="w-6 h-6 object-contain group-hover:scale-110 transition-transform duration-200"
               alt="logout" />
          <span class="text-gray-800 font-medium text-[15px] group-hover:text-red-600 transition-colors duration-200">
            Logout
          </span>
        </div>
      </li>

    </ul>

    <!-- LOCATION PAGE (disembunyikan awalnya) -->
    <div id="locationDetail" class="hidden mt-4">
      <button id="backFromLocation"
              class="flex items-center gap-2 text-[#6ca571] font-medium mb-3 hover:underline">
        ← Back
      </button>

      <div id="map" class="w-full h-[300px] rounded-xl border border-gray-200 shadow-sm"></div>

      <div class="mt-4 text-gray-700 text-sm">
        <p><strong>Latitude:</strong> <span id="lat">-</span></p>
        <p><strong>Longitude:</strong> <span id="lng">-</span></p>
      </div>
    </div>

  </div>
</section>


<script>
  // === PROFILE DROPDOWN ===
  const profileButton = document.getElementById("profileButton");
  const profileDropdown = document.getElementById("profileDropdown");
  const arrowIcon = document.getElementById("arrowIcon");
  let isOpen = false;

  profileButton.addEventListener("click", (e) => {
    e.stopPropagation();
    isOpen = !isOpen;
    profileDropdown.classList.toggle("hidden", !isOpen);
    arrowIcon.classList.toggle("rotate-90", isOpen);
  });

  document.addEventListener("click", (e) => {
    if (!profileButton.contains(e.target)) {
      profileDropdown.classList.add("hidden");
      arrowIcon.classList.remove("rotate-90");
      isOpen = false;
    }
  });

  // === LOCATION FEATURE ===
  const locationButton = document.getElementById("locationButton");
  const locationDetail = document.getElementById("locationDetail");
  const menuList = document.getElementById("menuList");
  const backFromLocation = document.getElementById("backFromLocation");

  locationButton.addEventListener("click", () => {
    menuList.classList.add("hidden");
    locationDetail.classList.remove("hidden");
    initMap();
  });

  backFromLocation.addEventListener("click", () => {
    locationDetail.classList.add("hidden");
    menuList.classList.remove("hidden");
  });

  let map, marker;
  function initMap() {
    const indonesia = { lat: -6.200000, lng: 106.816666 }; // Jakarta default
    map = new google.maps.Map(document.getElementById("map"), {
      center: indonesia,
      zoom: 12,
    });

    map.addListener("click", (event) => {
      const position = event.latLng;
      if (marker) marker.setMap(null);
      marker = new google.maps.Marker({ position, map });
      document.getElementById("lat").textContent = position.lat().toFixed(6);
      document.getElementById("lng").textContent = position.lng().toFixed(6);
    });

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const userLocation = {
            lat: pos.coords.latitude,
            lng: pos.coords.longitude,
          };
          map.setCenter(userLocation);
          marker = new google.maps.Marker({ position: userLocation, map });
          document.getElementById("lat").textContent = userLocation.lat.toFixed(6);
          document.getElementById("lng").textContent = userLocation.lng.toFixed(6);
        },
        () => console.log("Tidak dapat mengakses lokasi pengguna")
      );
    }
  }
</script>

<script async
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKFLZQzfwQET0dTdO-1w1XnZgrbjmUnmY&callback=initMap">
</script>

</body>
</html>

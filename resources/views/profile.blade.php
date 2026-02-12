<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100 antialiased min-h-screen">

<div class="w-full max-w-[450px] bg-white min-h-screen shadow-sm mx-auto">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#7BAE7F] to-[#6B9F6F] pt-6 pb-6 text-center text-white relative shadow-lg">
        <a href="/" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full transition-all hover:scale-110 backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-bold tracking-wide">My Profile</h1>
    </div>

    <!-- PROFILE CENTER -->
    <div class="-mt-20 flex flex-col items-center text-center px-6 mt-[50px]">
        <form id="uploadForm" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="relative w-36 h-36 mx-auto">
                <img id="avatarPreview" 
                    src="{{ auth()->user()->image
                        ? Storage::url('profile_images/' . auth()->user()->image)
                        : 'https://randomuser.me/api/portraits/men/32.jpg' }}"
                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-xl">
                
                <!-- Tombol Camera di pojok kanan bawah -->
                <label for="upload-photo" class="absolute bottom-1 right-1 bg-blue-600 p-2 rounded-full border-2 border-white shadow-md cursor-pointer hover:bg-blue-700 transition-all hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </label>
                
                <input type="file" id="upload-photo" name="file_input" accept="image/*" class="hidden">
            </div>
            
            <!-- Tombol Upload (muncul setelah pilih foto) -->
            <button type="submit" id="uploadBtn" class="hidden mt-3 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full font-semibold transition-all shadow-md hover:scale-105">
                Upload Foto
            </button>
        </form>

        <h2 class="mt-5 text-3xl font-bold text-gray-800">
            {{ auth()->user()->name }}
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            {{ auth()->user()->email }}
        </p>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mt-3 px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
        <div class="mt-3 px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
        @endif
    </div>

    <!-- MENU LIST -->
    <div class="mt-10 divide-y">

        <!-- PROFILE DROPDOWN -->
        <div>
            <button onclick="toggle('profileDrop','arrowProfile')"
                class="w-full flex justify-between items-center px-6 py-4 text-gray-700">
                <span class="flex items-center gap-2">👤 Profil</span>
                <span id="arrowProfile" class="text-xl transition-transform">›</span>
            </button>

            <div id="profileDrop"
                class="hidden px-6 pb-4 text-sm text-gray-600 space-y-2">
                <p><b>Nama:</b> {{ auth()->user()->name }}</p>
                <p><b>Email:</b> {{ auth()->user()->email }}</p>
                <p><b>Alamat Tersimpan:</b><br>
                    {{ $lokasi->alamat ?? 'Belum disimpan' }}
                </p>
            </div>
        </div>

        <!-- LOKASI DROPDOWN -->
        <div>
            <button onclick="toggle('lokasiDrop','arrowLokasi')"
                class="w-full flex justify-between items-center px-6 py-4 text-green-700">
                <span class="flex items-center gap-2">📍 Lokasi</span>
                <span id="arrowLokasi" class="text-xl transition-transform">›</span>
            </button>

            <div id="lokasiDrop" class="hidden px-6 pb-5 space-y-3">

                <button id="locationBtn"
                    class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold">
                    Deteksi Lokasi (GPS)
                </button>

                <div id="map" class="hidden w-full h-[260px] rounded-lg"></div>

                <p class="text-xs text-gray-500">
                    Geser pin jika titik lokasi belum tepat agar kurir mudah menemukan alamat.
                </p>

                <form method="POST" action="{{ route('lokasi.store') }}" class="space-y-2">
                    @csrf
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">

                    <textarea id="alamat" name="alamat" readonly
                        class="w-full p-3 text-xs border rounded-lg bg-gray-100"
                        rows="4"
                        placeholder="Alamat lengkap otomatis"></textarea>

                    <textarea name="catatan"
                        class="w-full p-3 text-xs border rounded-lg"
                        placeholder="Catatan kurir (warna pagar, patokan rumah, dll)"></textarea>

                    <button id="saveBtn" disabled
                        class="w-full py-3 bg-green-600 text-white rounded-lg font-bold opacity-50">
                        Simpan Lokasi
                    </button>
                </form>
            </div>
        </div>

        <!-- CHANGE PASSWORD -->
        <a href="/views/change_password"
            class="flex justify-between items-center px-6 py-4 text-yellow-700">
            <span class="flex items-center gap-2">🔑 Change Password</span>
            <span class="text-xl">›</span>
        </a>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="w-full flex justify-between items-center px-6 py-4 text-red-600">
                <span class="flex items-center gap-2">🚪 Logout</span>
                <span class="text-xl">›</span>
            </button>
        </form>

    </div>

</div>

<script>
let map, marker;

function toggle(id, arrowId) {
    const el = document.getElementById(id);
    const arrow = document.getElementById(arrowId);
    el.classList.toggle("hidden");
    arrow.classList.toggle("rotate-90");
}

async function reverseGeocode(lat, lng) {
    const res = await fetch(
        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
    );
    const data = await res.json();
    return data.display_name || "";
}

// Handle file input change untuk preview foto
document.getElementById("upload-photo").addEventListener("change", function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById("avatarPreview").src = event.target.result;
        };
        reader.readAsDataURL(file);
        
        // Tampilkan tombol upload
        document.getElementById("uploadBtn").classList.remove("hidden");
    }
});

document.getElementById("locationBtn").onclick = () => {
    navigator.geolocation.getCurrentPosition(async pos => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        const mapEl = document.getElementById("map");
        mapEl.classList.remove("hidden");

        if (!map) {
            map = L.map("map").setView([lat, lng], 17);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);

            marker.on("dragend", async () => {
                const p = marker.getLatLng();
                document.getElementById("alamat").value =
                    await reverseGeocode(p.lat, p.lng);
            });
        } else {
            map.setView([lat, lng], 17);
            marker.setLatLng([lat, lng]);
        }

        document.getElementById("alamat").value =
            await reverseGeocode(lat, lng);

        map.invalidateSize();

        const btn = document.getElementById("saveBtn");
        btn.disabled = false;
        btn.classList.remove("opacity-50");
    });
};
</script>

</body>
</html>

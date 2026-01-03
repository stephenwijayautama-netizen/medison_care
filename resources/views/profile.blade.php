<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gradient-to-b from-[#EEF3EE] to-[#F6F8F5] min-h-screen flex justify-center items-center">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- HEADER -->
        <div class="bg-[#7BAE7F] py-6 text-center text-white relative">
            <a href="/" class="absolute left-4 top-4 text-xl hover:opacity-80">←</a>
            <h1 class="text-xl font-bold tracking-wide">My Profile</h1>
        </div>

        <!-- PROFILE -->
        <div class="px-6 py-8 text-center">
            <img src="{{ auth()->user()->image
                ? Storage::url('profile_images/' . auth()->user()->image)
                : 'https://randomuser.me/api/portraits/men/32.jpg' }}"
                class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-white shadow-lg">

            <h2 class="mt-4 font-semibold text-lg text-gray-800">
                {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ auth()->user()->email }}
            </p>
        </div>

        <!-- MENU -->
        <div class="px-5 pb-6">
            <ul class="space-y-4 text-sm">

                <!-- PROFILE DETAIL -->
                <li class="bg-gray-50 rounded-2xl p-4 shadow-sm">
                    <button onclick="toggleProfile()" class="flex justify-between items-center w-full font-medium text-gray-700">
                        <span class="flex items-center gap-2">👤 Informasi Profil</span>
                        <span class="text-lg">›</span>
                    </button>

                    <ul id="profileDropdown" class="hidden mt-4 space-y-2 text-gray-600">
                        <li>Nama: {{ auth()->user()->name }}</li>
                        <li>Email: {{ auth()->user()->email }}</li>
                        <li>Alamat: {{ $lokasi->alamat ?? 'Alamat belum disimpan' }}</li>
                    </ul>
                </li>

                <!-- CHANGE PASSWORD -->
                <a href="/views/change_password">
                    <li class="flex items-center justify-between px-4 py-4 rounded-2xl mt-[20px]
                               bg-yellow-50 hover:bg-yellow-100 transition cursor-pointer">
                        <span class="font-medium text-yellow-700">🔑 Change Password</span>
                        <span class="text-yellow-500 text-lg">›</span>
                    </li>
                </a>

                <!-- LOCATION -->
                <li id="locationBtn"
                    class="bg-green-100 text-green-800 rounded-2xl p-4 cursor-pointer text-center font-medium hover:bg-green-200 transition">
                    📍 Tampilkan Lokasi Saya
                </li>

                <!-- MAP -->
                <div id="map" class="hidden w-full h-[230px] rounded-2xl shadow"></div>

                <!-- ADDRESS -->
                <form method="POST" action="{{ route('lokasi.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">

                    <input id="address" name="alamat" readonly
                        class="w-full px-4 py-2 border rounded-xl bg-gray-100 text-sm"
                        placeholder="Alamat akan muncul otomatis">

                    <button id="saveBtn" disabled
                        class="w-full py-2 bg-green-600 text-white rounded-xl opacity-50 font-medium">
                        Simpan Lokasi
                    </button>
                </form>

                <!-- LOGOUT -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="w-full bg-red-50 text-red-600 rounded-2xl p-4 font-semibold hover:bg-red-100 transition">
                        Logout
                    </button>
                </form>

            </ul>
        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        let map, marker;

        function toggleProfile() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }

        async function getAddress(lat, lng) {
            const res = await fetch(
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
            );
            const data = await res.json();
            return data.display_name ?? "Alamat tidak ditemukan";
        }

        document.getElementById("locationBtn").onclick = () => {
            navigator.geolocation.getCurrentPosition(async pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;

                const address = await getAddress(lat, lng);
                document.getElementById("address").value = address;

                document.getElementById("map").classList.remove("hidden");

                setTimeout(() => {
                    if (!map) {
                        map = L.map("map").setView([lat, lng], 15);
                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
                        marker = L.marker([lat, lng]).addTo(map);
                    } else {
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);
                    }

                    marker.bindPopup(`📍 Lokasi Anda<br>${address}`).openPopup();
                    map.invalidateSize();

                    const btn = document.getElementById("saveBtn");
                    btn.disabled = false;
                    btn.classList.remove("opacity-50");
                }, 200);
            });
        };
    </script>

</body>
</html>

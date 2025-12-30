<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Medison Care') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F6F8F5] min-h-screen flex items-center justify-center font-sans">
    <!-- PAGE WRAPPER -->
    <div class="w-full px-4 flex justify-center">
        <div class="w-full max-w-sm sm:max-w-md bg-white rounded-3xl shadow-xl overflow-hidden">

            <!-- HEADER -->
            <div class="relative bg-[#7BAE7F] py-6 text-center rounded-b-3xl">
                <a href="/"
                    class="absolute left-4 top-5 w-9 h-9 bg-white/30 rounded-full flex items-center justify-center hover:bg-white/50 transition">
                    ←
                </a>
                <h1 class="text-white text-xl font-bold">My Profile</h1>
            </div>

            <!-- PROFILE SECTION -->
            <div class="px-6 py-8 text-center">
                <!-- PROFILE IMAGE WITH UPLOAD BUTTON -->
                <div class="relative w-fit mx-auto">
                    <img id="profileImage"
                        src="{{ auth()->user()->image ? Storage::url('profile_images/' . auth()->user()->image) : 'https://randomuser.me/api/portraits/men/32.jpg' }}"
                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md"
                        alt="Profile Picture" />

                    <!-- UPLOAD BUTTON -->
                    <button onclick="document.getElementById('file_input').click()"
                        class="absolute bottom-1 right-1 w-10 h-10 bg-[#7BAE7F] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-[#ffffff] transition"
                        aria-label="Change photo">
                        📷
                    </button>
                </div>

                <!-- HIDDEN UPLOAD FORM -->
                <form id="uploadForm" action="{{ route('profile.upload') }}" method="POST"
                    enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" name="file_input" id="file_input" accept="image/*" capture="environment"
                        onchange="handleUpload(event)">
                </form>

                <!-- USER INFO -->
                <h2 class="mt-4 text-lg font-semibold">
                    {{ auth()->user()->name ?? 'Stephen' }}
                </h2>
                <p class="text-sm italic text-gray-500">
                    Member since 2023
                </p>

            </div>

            <!-- MENU SECTION -->
            <div class="px-4 pb-6">
                <ul class="space-y-2 text-sm">
                    <!-- PROFILE -->
                    <li class="flex justify-between items-center px-4 py-3 rounded-xl hover:bg-gray-50 cursor-pointer">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="flex justify-between w-full">
                            <span>Profile</span>
                            <span>›</span>
                        </a>
                    </li>

                    <!-- CHANGE PASSWORD -->
                    <a href="/views/change_password">
                        <li class="px-4 py-3 rounded-xl hover:bg-gray-50 cursor-pointer">
                            Change Password
                        </li>
                    </a>

                    <!-- LOCATION -->
                    <li>
                        <div>
                            <ul class="space-y-4">
                                <li id="locationItem"
                                    class="px-4 py-3 rounded-xl bg-green-100 hover:bg-green-200 cursor-pointer flex items-center gap-3 transition">
                                    <span class="text-green-700 text-xl">📍</span>
                                    <span class="font-semibold text-gray-800">
                                        Tampilkan Lokasi
                                    </span>
                                </li>
                            </ul>

                            <!-- MAP -->
                            <div id="map" class="mt-4 w-full h-[280px] rounded-xl overflow-hidden hidden">
                            </div>

                            <!-- FORM SIMPAN LOKASI -->
                            <form method="POST" action="{{ route('lokasi.store') }}" class="mt-4 space-y-3">
                                @csrf

                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">

                                <input type="text" name="alamat" id="address" readonly
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-sm"
                                    placeholder="Alamat akan muncul di sini">

                                <button id="btnSaveLocation" type="submit" disabled
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700
                       text-white rounded-lg opacity-50 cursor-not-allowed transition">
                                    Simpan Lokasi
                                </button>
                            </form>
                        </div>
                    </li>



                    <!-- LOGOUT -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full">
                            <li class="px-4 py-3 rounded-xl hover:bg-red-50 text-red-500">
                                Logout
                            </li>
                        </button>
                    </form>
                </ul>
            </div>

        </div>
    </div>

    <!-- SCRIPTS -->

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const item = document.getElementById("locationItem");
            const mapEl = document.getElementById("map");

            const latInput = document.getElementById("latitude");
            const lngInput = document.getElementById("longitude");
            const addressInput = document.getElementById("address");
            const btnSave = document.getElementById("btnSaveLocation");

            if (!item || !mapEl || !latInput || !lngInput || !addressInput || !btnSave) {
                console.error("Beberapa elemen DOM tidak ditemukan, skrip dihentikan.");
                return;
            }

            let map = null;
            let marker = null;

            // 🔹 reverse geocoding (ambil alamat lengkap)
            async function getAddress(lat, lng) {
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`, {
                            headers: {
                                "User-Agent": "LaravelApp/1.0 (stephen@binus.ac.id)"
                            }
                        }
                    );

                    if (!res.ok) return "Alamat tidak ditemukan";

                    const data = await res.json();

                    // Prioritaskan display_name
                    if (data.display_name) return data.display_name;

                    // fallback menggunakan data.address
                    if (data.address) {
                        const {
                            road,
                            suburb,
                            city,
                            state,
                            postcode,
                            country
                        } = data.address;
                        return [road, suburb, city, state, postcode, country].filter(Boolean).join(", ");
                    }

                    return "Alamat tidak ditemukan";
                } catch (error) {
                    console.error("Error fetch alamat:", error);
                    return "Alamat tidak ditemukan";
                }
            }

            item.addEventListener("click", () => {
                if (!navigator.geolocation) {
                    alert("Browser tidak mendukung Geolocation");
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;

                            // tampilkan map
                            mapEl.classList.remove("hidden");

                            // isi input koordinat
                            latInput.value = lat;
                            lngInput.value = lng;

                            setTimeout(async () => {
                                // buat map jika belum ada
                                if (!map) {
                                    map = L.map("map").setView([lat, lng], 15);

                                    L.tileLayer(
                                        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                            attribution: "© OpenStreetMap"
                                        }
                                    ).addTo(map);
                                } else {
                                    map.setView([lat, lng], 15);
                                }

                                // buat marker jika belum ada
                                if (!marker) {
                                    marker = L.marker([lat, lng]).addTo(map);
                                } else {
                                    marker.setLatLng([lat, lng]);
                                }

                                // ambil alamat
                                const address = await getAddress(lat, lng);
                                addressInput.value = address;

                                marker
                                    .bindPopup(`<b>📍 Lokasi Anda</b><br>${address}`)
                                    .openPopup();

                                // WAJIB biar map tidak rusak
                                map.invalidateSize();

                                // aktifkan tombol simpan lokasi
                                btnSave.disabled = false;
                                btnSave.classList.remove("opacity-50",
                                "cursor-not-allowed");
                            }, 200);
                        },
                        (err) => {
                            alert("Gagal mengambil lokasi: " + err.message);
                        }
                );
            });
        });
    </script>


</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - Medison Care</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.11/dist/dotlottie-wc.js" type="module"></script>
</head>

<body class="font-inter bg-gray-100 flex justify-center items-center min-h-screen p-4">

<div class="bg-white w-full max-w-[900px] shadow-2xl rounded-[35px] overflow-hidden flex flex-col md:flex-row">

    <!-- LEFT -->
    <div class="md:w-5/12 flex flex-col items-center justify-center p-6 border-b md:border-b-0 md:border-r">
        <div class="w-[250px] h-[250px]">
            <dotlottie-wc
                src="https://lottie.host/bd7a9b3c-a1cf-4afd-832d-5b12afaa3092/jaEv8tVuTG.lottie"
                autoplay loop>
            </dotlottie-wc>
        </div>

        <div class="text-center -mt-4">
            <h1 class="text-[#009345] font-bold text-2xl">Medison Care</h1>
            <p class="text-gray-400 text-xs tracking-widest uppercase font-semibold">
                Join Our Community
            </p>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="md:w-7/12 p-6 md:p-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>

        <form action="{{ route('doRegister') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- NAMA -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

                <!-- EMAIL -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Email
                    </label>
                    <input type="email" name="email" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

                <!-- ROLE -->
                @php
                    $userRole = $roles->firstWhere('position', 'user');
                @endphp

                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Role
                    </label>

                    {{-- 1. INPUT HIDDEN: Ini yang akan mengirim data 'role_id' ke server --}}
                    <input type="hidden" name="role_id" value="{{ $userRole ? $userRole->id : '' }}">

                    {{-- 2. SELECT VISUAL: Hanya untuk tampilan user, statusnya disabled --}}
                    <select disabled
                        class="h-[45px] px-4 border rounded-2xl bg-gray-100 text-gray-500 cursor-not-allowed outline-none text-sm">
                        
                        @if($userRole)
                            {{-- Langsung pilih role user --}}
                            <option value="{{ $userRole->id }}" selected>
                                {{ $userRole->position }}
                            </option>
                        @else
                            {{-- Fallback jika role 'user' belum dibuat di database --}}
                            <option value="">Role User Tidak Ditemukan</option>
                        @endif

                    </select>
                </div>

                <!-- TELEPON -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Telepon
                    </label>
                    <input type="text" name="phone" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

                <!-- ALAMAT -->
                <div class="flex flex-col space-y-1 sm:col-span-2">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Alamat
                    </label>
                    <input type="text" name="address" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

                <!-- PASSWORD -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Password
                    </label>
                    <input type="password" name="password" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

                <!-- KONFIRMASI -->
                <div class="flex flex-col space-y-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">
                        Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="h-[45px] px-4 border rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm">
                </div>

            </div>

            <div class="mt-8">
                <button type="submit"
                    class="w-full h-[52px] bg-[#009345] hover:bg-[#007a3a] text-white rounded-2xl font-bold shadow-lg transition active:scale-95">
                    DAFTAR SEKARANG
                </button>

                <p class="text-center text-gray-400 text-sm mt-4">
                    Sudah punya akun?
                    <a href="/login" class="text-[#009345] font-bold hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>

</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.11/dist/dotlottie-wc.js" type="module"></script>
    <title>Register - Medison Care</title>
</head>

<body class="font-inter bg-gray-100 flex justify-center items-center min-h-[100dvh] p-4 sm:p-6 md:p-10">

    <div class="bg-white w-full max-w-[900px] shadow-2xl rounded-[35px] overflow-hidden border border-gray-100 flex flex-col md:flex-row transition-all duration-300">
        
        <div class="md:w-5/12 bg-white flex flex-col items-center justify-center p-6 border-b md:border-b-0 md:border-r border-gray-50">
            <div class="w-[200px] h-[200px] sm:w-[250px] sm:h-[250px] md:w-[300px] md:h-[300px]">
                <dotlottie-wc 
                    src="https://lottie.host/bd7a9b3c-a1cf-4afd-832d-5b12afaa3092/jaEv8tVuTG.lottie" 
                    class="w-full h-full"
                    autoplay 
                    loop>
                </dotlottie-wc>
            </div>
            <div class="text-center -mt-4">
                <h1 class="text-[#009345] font-bold text-2xl md:text-3xl">Medison Care</h1>
                <p class="text-gray-400 text-[10px] sm:text-xs tracking-widest uppercase font-semibold">Join Our Community</p>
            </div>
        </div>

        <div class="md:w-7/12 p-6 sm:p-8 md:p-12 bg-white">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 hidden md:block">Create Account</h2>
            
            <form action="{{ route('doRegister') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <div class="flex flex-col space-y-1">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Nama Anda" required
                            class="w-full h-[45px] px-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none text-sm transition-all" />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Email</label>
                        <input type="email" name="email" placeholder="mail@domain.com" required
                            class="w-full h-[45px] px-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none text-sm transition-all" />
                    </div>

                        @php
                            $userRole = $roles->firstWhere('position', 'user');
                        @endphp

                        <div class="flex flex-col space-y-1">
                            <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Role</label>
                            <input type="hidden" name="role_id" value="{{ $userRole ? $userRole->id : '' }}">
                            <select disabled
                                class="w-full h-[45px] px-4 border border-gray-200 rounded-2xl outline-none text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                @if($userRole)
                                    <option value="{{ $userRole->id }}" selected>{{ $userRole->position }}</option>
                                @else
                                    <option value="">Role User Tidak Ditemukan</option>
                                @endif
                            </select>
                        </div>

                    <div class="flex flex-col space-y-1">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Telepon</label>
                        <input type="text" name="phone" placeholder="0812..."
                            class="w-full h-[45px] px-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none text-sm transition-all" />
                    </div>

                    <div class="flex flex-col space-y-1 sm:col-span-2">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Alamat</label>
                        <input type="text" name="address" placeholder="Alamat lengkap"
                            class="w-full h-[45px] px-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none text-sm transition-all" />
                    </div>

                    <div class="flex flex-col space-y-1 relative">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="w-full h-[45px] px-4 pr-10 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm" />
                            <button type="button" onclick="togglePass('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-1 relative">
                        <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Konfirmasi</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required
                                class="w-full h-[45px] px-4 pr-10 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] outline-none text-sm" />
                            <button type="button" onclick="togglePass('password_confirmation')" class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="mt-8 space-y-4">
                    <button type="submit"
                        class="w-full h-[52px] bg-[#009345] hover:bg-[#007a3a] text-white rounded-2xl font-bold text-sm shadow-lg shadow-green-100 transition-all active:scale-95 uppercase tracking-wider">
                        DAFTAR SEKARANG
                    </button>
                    
                    <p class="text-center text-gray-400 text-[12px]">
                        Sudah punya akun? 
                        <a href="/login" class="text-[#009345] font-bold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>

</body>
</html>
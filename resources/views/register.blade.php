<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-[Inter] bg-[#f4f4f4] ml-[200px]">
    <section>
        <div>
            <p class="text-black font-bold text-3xl ml-[480px] mt-[100px]">Register</p>
        </div>

        <form action="{{ route('doRegister') }}" method="POST" class="px-6">
            @csrf

            <div
                class="bg-white w-[300px] h-auto border border-gray-400 shadow-md rounded-[45px] ml-[370px] mt-[25px] pb-6">

                <!-- Tombol Navigasi -->

                <!-- Nama -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="nama" class="text-md font-semibold text-black">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama" required
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div>

                <!-- Email -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="email" class="text-md font-semibold text-black">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email" required
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div>

                <!-- Tanggal Lahir -->
                <!-- <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="tanggal_lahir" class="text-md font-semibold text-black">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div> -->

                <!-- Role -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="role_id" class="text-md font-semibold text-black">Role</label>
                    <select name="role_id" id="role_id" required
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm">
                        <option value="">Pilih Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->position }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Phone -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="phone" class="text-md font-semibold text-black">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Masukkan nomor telepon"
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div>

                <!-- Address -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px]">
                    <label for="address" class="text-md font-semibold text-black">Address</label>
                    <input type="text" id="address" name="address" placeholder="Masukkan alamat"
                        class="w-[220px] h-[40px] px-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div>

                <!-- Password -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px] relative">
                    <label for="password" class="text-md font-semibold text-black">Password</label>
                    <div class="relative w-[220px]">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required
                            class="w-full h-[40px] px-3 pr-10 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-[#597445]">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="flex flex-col space-y-1 mt-[15px] ml-[40px] relative">
                    <label for="password_confirmation" class="text-md font-semibold text-black">Confirm Password</label>
                    <div class="relative w-[220px]">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Masukkan ulang password" required
                            class="w-full h-[40px] px-3 pr-10 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                        <button type="button" onclick="toggleConfirmPassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-[#597445]">
                            <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Register -->
                <div class="ml-[40px] mt-[20px]">
                    <button type="submit"
                        class="bg-[#4a6339] w-[220px] h-[40px] rounded-[20px] shadow-sm text-white font-semibold text-[18px] flex items-center justify-center hover:bg-[#3e562f] transition">
                        Register
                    </button>
                </div>

                <!-- Sudah punya akun -->
                <div class="ml-[40px] mt-[10px] text-[10px] font-[Inter]">
                    <span class="text-[#4a6339] font-semibold">Already have an account? </span>
                    <a href="/login" class="text-[#4a6339] font-medium hover:underline">Login here</a>
                </div>

            </div>
        </form>
    </section>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (input.type === "password") input.type = "text";
            else input.type = "password";
        }

        function toggleConfirmPassword() {
            const input = document.getElementById("password_confirmation");
            const icon = document.getElementById("eyeConfirmIcon");
            if (input.type === "password") input.type = "text";
            else input.type = "password";
        }
    </script>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-red-500">
            Logout
        </button>
    </form>

</body>

</html>

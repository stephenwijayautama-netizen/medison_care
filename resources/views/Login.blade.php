<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="font-inter bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <section class="w-full flex flex-col items-center">

        <p class="text-black font-bold text-3xl mb-4">Login</p>

        <!-- CARD -->
        <div class="bg-white w-full max-w-[340px] py-6 border border-gray-300 shadow-md rounded-[25px]">

            <!-- FORM LOGIN -->
            <form action="{{ route('doLogin') }}" method="POST" class="px-6">
                @csrf

                <!-- Email -->
                <div class="flex flex-col space-y-1 mb-4">
                    <label class="text-md font-semibold text-black">Email</label>
                    <input type="email" name="email" required
                        class="w-full h-[40px] px-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />
                </div>

                <!-- Password -->
                <div class="flex flex-col space-y-1 mb-3">
                    <label class="text-md font-semibold text-black">Password</label>

                    <div class="relative w-full">
                        <input type="password" name="password" id="password" required
                            class="w-full h-[40px] px-3 pr-10 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-[#597445] shadow-sm text-sm" />

                        <!-- Eye Icon -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="w-full text-right">
                    <a href="/Forgot" class="text-[#4a6339] text-[12px] font-medium">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="mt-4 bg-[#4a6339] w-full h-[40px] rounded-[20px] text-white font-semibold text-[16px] shadow-sm">
                    Login
                </button>
            </form>

            <!-- Register Now -->
            <div class="text-center mt-4">
                <a href="/register" class="text-[#4a6339] text-[12px]">
                    Not a member? <span class="font-semibold">Register now</span>
                </a>
            </div>

        </div>
    </section>

    <!-- SHOW/HIDE PASSWORD JS -->
    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19
                        c-4.478 0-8.268-2.943-9.542-7
                        a9.958 9.958 0 012.152-3.293"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3l18 18" />`;
            } else {
                password.type = "password";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                        c4.478 0 8.268 2.943 9.542 7
                        -1.274 4.057-5.064 7-9.542 7
                        -4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>

</body>

</html>

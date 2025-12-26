<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.11/dist/dotlottie-wc.js" type="module"></script>
    <title>Login - Medison Care</title>
</head>

<body class="font-inter bg-gray-100 flex justify-center items-center min-h-[100dvh] p-4">

    <div class="bg-white w-full max-w-[400px] shadow-2xl rounded-[35px] overflow-hidden border border-gray-100 transition-all duration-300">
        
        <div class="flex flex-col items-center pt-4 bg-white px-4">
            <div class="w-full flex justify-center overflow-hidden">
                <dotlottie-wc 
                    src="https://lottie.host/ee02ced2-dee2-48c0-868a-8eddd0f85946/SKYthYtfCw.lottie" 
                    style="width: 280px; height: 280px;" 
                    autoplay 
                    loop>
                </dotlottie-wc>
            </div>
            
            <div class="text-center -mt-4 pb-4">
                <h1 class="text-[#009345] font-bold text-2xl sm:text-3xl">Medison Care</h1>
                <p class="text-gray-400 text-[10px] sm:text-xs tracking-wide uppercase font-semibold">Login to your account</p>
            </div>
        </div>

        <div class="px-6 pb-8 sm:px-10 sm:pb-12">
            <form action="{{ route('doLogin') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-[10px] sm:text-xs font-bold text-gray-500 mb-2 ml-1 uppercase text-left">Email Address</label>
                    <input type="email" name="email" placeholder="email@domain.com" required
                        class="w-full h-[48px] px-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none shadow-sm text-sm transition-all" />
                </div>

                <div class="mb-2">
                    <label class="block text-[10px] sm:text-xs font-bold text-gray-500 mb-2 ml-1 uppercase text-left">Password</label>
                    <div class="relative w-full">
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full h-[48px] px-4 pr-12 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#009345] focus:border-transparent outline-none shadow-sm text-sm transition-all" />

                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-[#009345]">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="text-right mb-6">
                    <a href="/Forgot" class="text-[#009345] text-[10px] sm:text-[11px] font-bold hover:underline uppercase tracking-tight">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full h-[52px] bg-[#009345] hover:bg-[#007a3a] text-white rounded-2xl font-bold text-sm shadow-lg shadow-green-100 transition-all active:scale-95 mb-6 uppercase tracking-wider">
                    LOGIN
                </button>
            </form>

            <div class="text-center">
                <p class="text-gray-400 text-[11px] sm:text-[12px]">
                    Don't have an account? 
                    <a href="/register" class="text-[#009345] font-bold hover:underline">Register Now</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.958 9.958 0 012.152-3.293M3 3l18 18" />
                `;
            } else {
                password.type = "password";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>

</body>
</html>
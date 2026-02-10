<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Forgot Password</title>
</head>
<body class="bg-[#f4f4f4] min-h-screen flex items-center justify-center">

<section class="flex flex-col items-center">
    <p class="text-black font-bold text-3xl mb-6">Forgot Password</p>

    <div class="bg-white w-[320px] border border-gray-300 shadow-md rounded-[35px] pb-6">
        
        @if (session('error'))
            <p class="text-red-500 text-sm text-center mt-3">
                {{ session('error') }}
            </p>
        @endif

        @if (session('success'))
            <p class="text-green-600 text-sm text-center mt-3">
                {{ session('success') }}
            </p>
        @endif

        <form method="POST" action="/forgot-password">
            @csrf

            <div class="flex flex-col space-y-1 mt-4 px-8">
                <label class="text-sm font-semibold">Email</label>
                <input type="email" name="email" required
                    placeholder="Masukkan Email"
                    class="h-[40px] px-3 border rounded-xl focus:ring-2 focus:ring-[#597445]"
                />
            </div>

            <div class="flex justify-center mt-5">
                <button class="bg-[#4a6339] w-[220px] h-[40px] rounded-[20px] text-white font-semibold hover:bg-[#3e562f] transition">
                    Confirm Email
                </button>
            </div>
        </form>
    </div>
</section>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konsultasi Apoteker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .phone {
            aspect-ratio: 9 / 16;
            max-width: 390px;
            margin: auto;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen flex items-center justify-center">

    <div class="phone bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white p-6 text-center">
            <h1 class="text-2xl font-bold tracking-wide">
                Konsultasi Apoteker
            </h1>
            <p class="text-sm mt-2 opacity-90">
                Aman • Profesional • Terpercaya
            </p>
        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-6 flex flex-col justify-between">

            <!-- DESCRIPTION -->
            <div>
                <p class="text-gray-700 text-center leading-relaxed">
                    Bingung cara minum obat?
                    Khawatir dengan efek samping?
                </p>

                <p class="text-gray-700 text-center mt-3 leading-relaxed">
                    Konsultasikan langsung dengan
                    <span class="font-semibold text-green-600">
                        apoteker resmi
                    </span>
                    kami untuk solusi yang aman dan tepat.
                </p>
            </div>

            <!-- FEATURES -->
            <div class="mt-6 space-y-3">
                <div class="flex items-center gap-3 bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-lg">✔</span>
                    <span class="text-sm text-gray-700">Gratis & tanpa biaya</span>
                </div>

                <div class="flex items-center gap-3 bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-lg">✔</span>
                    <span class="text-sm text-gray-700">Privasi terjamin</span>
                </div>

                <div class="flex items-center gap-3 bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-lg">✔</span>
                    <span class="text-sm text-gray-700">Respon cepat via WhatsApp</span>
                </div>
            </div>

            <!-- CTA -->
            <div class="mt-8">
                <a
                    href="https://wa.me/6281234567890?text=Halo%20Apoteker,%20saya%20ingin%20konsultasi%20tentang%20obat"
                    target="_blank"
                    class="block w-full text-center bg-gradient-to-r from-green-600 to-emerald-500 hover:opacity-90 text-white font-semibold py-4 rounded-2xl shadow-lg transition"
                >
                    💬 Mulai Konsultasi Sekarang
                </a>

                <p class="text-xs text-gray-500 text-center mt-3">
                    Anda akan diarahkan ke WhatsApp
                </p>
            </div>

        </div>

    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Resep - Medison Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 flex justify-center items-center min-h-screen">

    <div class="relative bg-white w-full max-w-[450px] h-screen shadow-2xl flex flex-col md:rounded-[40px] md:border-[8px] md:border-gray-900 overflow-hidden font-[inter]">
        
        <header class="bg-[#009345] p-4 flex items-center gap-3 shadow-md z-50">
            <a href="javascript:history.back()" class="text-white">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-white font-bold text-lg">Unggah Resep</h1>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-5">
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <i class="fa-solid fa-circle-info text-blue-400 mt-1 mr-3"></i>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Pastikan foto resep terlihat jelas, terbaca, dan mencantumkan nama dokter serta tanggal resep.
                    </p>
                </div>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Resep</label>
                    <div id="dropzone" class="relative border-2 border-dashed border-gray-300 rounded-2xl bg-white p-8 text-center hover:border-[#009345] transition-all cursor-pointer">
                        <input type="file" name="resep" id="fileInput" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        
                        <div id="uploadContent">
                            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-camera text-[#009345] text-2xl"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-600">Klik atau Tarik Foto Resep</p>
                            <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG (Maks. 5MB)</p>
                        </div>

                        <div id="imagePreview" class="hidden">
                            <img src="" id="preview" class="max-h-64 mx-auto rounded-lg shadow-sm">
                            <p class="text-[10px] text-red-500 mt-2">Ketuk untuk ganti foto</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea 
                        name="notes" 
                        rows="3" 
                        placeholder="Contoh: Tolong siapkan obat generik saja..."
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-100 focus:border-[#009345] outline-none transition-all"
                    ></textarea>
                </div>

                <button type="submit" class="w-full bg-[#009345] text-white py-3 rounded-xl font-bold text-md shadow-lg shadow-green-100 hover:bg-green-700 active:scale-95 transition-all">
                    KIRIM RESEP SEKARANG
                </button>
            </form>

            <div class="mt-8 text-center">
                <div class="flex items-center justify-center gap-2 text-gray-400">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                    <span class="text-[10px] uppercase font-bold tracking-widest">Data Anda Terenkripsi & Aman</span>
                </div>
            </div>

        </main>

    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        const uploadContent = document.getElementById('uploadContent');

        fileInput.onchange = evt => {
            const [file] = fileInput.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('hidden');
                uploadContent.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
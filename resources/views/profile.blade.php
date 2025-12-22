<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Medison Care') }}</title>

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
       class="absolute left-4 top-5 w-9 h-9 bg-white/30 rounded-full
              flex items-center justify-center hover:bg-white/50 transition">
      ←
    </a>
    <h1 class="text-white text-xl font-bold">My Profile</h1>
  </div>

  <!-- PROFILE -->
  <div class="px-6 py-8 text-center">

    <!-- FOTO + FAB -->
    <div class="relative w-fit mx-auto">
      <img
        id="profileImage"
        src="{{ auth()->user()->image
          ? Storage::url('profile_images/' . auth()->user()->image)
          : 'https://randomuser.me/api/portraits/men/32.jpg' }}"
        class="w-32 h-32 rounded-full object-cover
               border-4 border-white shadow-md"
      />

      <!-- FLOATING BUTTON -->
      <button
        onclick="document.getElementById('file_input').click()"
        class="absolute bottom-1 right-1 w-10 h-10
               bg-[#7BAE7F] rounded-full flex items-center justify-center
               text-white shadow-lg hover:bg-[#6ca571] transition"
        aria-label="Change photo">
        📷
      </button>
    </div>

    <!-- HIDDEN FORM -->
    <form id="uploadForm"
          action="{{ route('profile.upload') }}"
          method="POST"
          enctype="multipart/form-data"
          class="hidden">
      @csrf
      <input
        type="file"
        name="file_input"
        id="file_input"
        accept="image/*"
        capture="environment"
        onchange="handleUpload(event)"
      >
    </form>

    <!-- USER INFO -->
    <h2 class="mt-4 text-lg font-semibold">
      {{ auth()->user()->name ?? 'Stephen' }}
    </h2>
    <p class="text-sm italic text-gray-500">
      Member since 2023
    </p>

    <a href="/views/change_profile"
       class="inline-block mt-4 px-6 py-2 rounded-full
              bg-[#7BAE7F] text-white text-sm
              hover:bg-[#6ca571] transition">
      Change Profile
    </a>
  </div>

  <!-- MENU -->
  <div class="px-4 pb-6">
    <ul class="space-y-2 text-sm">

      <li class="flex justify-between items-center px-4 py-3
                 rounded-xl hover:bg-gray-50 cursor-pointer">
        <span>Profile</span>
        <span>›</span>
      </li>

      <a href="/views/change_password">
        <li class="px-4 py-3 rounded-xl hover:bg-gray-50 cursor-pointer">
          Change Password
        </li>
      </a>

      <li class="px-4 py-3 rounded-xl hover:bg-gray-50 cursor-pointer">
        Location
      </li>

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

<!-- SCRIPT -->
<script>
function handleUpload(event) {
  const file = event.target.files[0];
  if (!file) return;

  // Preview image
  const reader = new FileReader();
  reader.onload = () => {
    document.getElementById('profileImage').src = reader.result;
  };
  reader.readAsDataURL(file);

  // Auto submit
  setTimeout(() => {
    document.getElementById('uploadForm').submit();
  }, 400);
}
</script>

</body>
</html>

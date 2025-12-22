<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#f4f8f0] to-[#e9f1e0] flex items-center justify-center font-[Inter]">
  <div class="bg-white shadow-2xl rounded-3xl w-full max-w-md p-8 animate-[fadeInUp_0.8s_ease]">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-[#85A35E] mb-2">Change Password</h2>
      <p class="text-gray-500 text-sm">Update your password to keep your account secure</p>
    </div>

    @if (session('success'))
      <div class="mb-4 rounded-xl bg-green-50 text-green-700 px-4 py-3 text-sm">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('change-password.submit') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1" for="current_password">Current Password</label>
        <input
          type="password"
          id="current_password"
          name="current_password"
          placeholder="Enter current password"
          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-700 focus:ring-2 focus:ring-[#85A35E] focus:border-[#85A35E] outline-none transition @error('current_password') border-red-400 @enderror"
          required
        />
        @error('current_password')
          <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1" for="password">New Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Enter new password"
          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-700 focus:ring-2 focus:ring-[#85A35E] focus:border-[#85A35E] outline-none transition @error('password') border-red-400 @enderror"
          required
        />
        @error('password')
          <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1" for="password_confirmation">Confirm New Password</label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          placeholder="Re-enter new password"
          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-700 focus:ring-2 focus:ring-[#85A35E] focus:border-[#85A35E] outline-none transition"
          required
        />
      </div>

      <button
        type="submit"
        class="w-full bg-[#85A35E] hover:bg-[#759353] text-white font-semibold py-2.5 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg"
      >
        Update Password
      </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
      <a href="/profile" class="text-[#85A35E] font-medium hover:underline">← Back</a>
    </p>
  </div>
</body>
</html>

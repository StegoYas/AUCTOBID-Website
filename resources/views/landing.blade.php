<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e9c176] flex items-center justify-center min-h-screen px-4">
    <div class="text-center">
        <!-- Logo -->
        <div class="mb-6">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="mx-auto w-32 h-32 rounded-full shadow-lg">
        </div>

        <!-- Judul -->
        <h1 class="text-4xl font-bold mb-4 text-gray-800">Welcome</h1>
        <p class="text-gray-500 mb-8"></p>

        <!-- Tombol -->
        <div class="flex justify-center space-x-4">
           <a href="{{ route('login') }}"
   class="bg-white text-gray-800 px-6 py-2 rounded-lg shadow hover:bg-gray-100 transition">
   Login
</a>

<a href="{{ route('register') }}"
   class="bg-[#a55e00] text-white px-6 py-2 rounded-lg shadow hover:bg-[#8f4f00] transition">
   Register
</a>
        </div>
    </div>
</body>
</html>

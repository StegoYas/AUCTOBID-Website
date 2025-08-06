<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuctoBid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-[#d1a75e] flex items-center justify-between px-8 py-4 shadow-lg">
        <div>
            <span class="font-semibold text-2xl text-white tracking-wide">AuctoBid</span>
        </div>
        <div class="flex space-x-6">
            <a href="{{ url('/') }}" class="text-white hover:text-gray-100 transition duration-200">Home</a>
            <a href="{{ url('/#contact') }}" class="text-white hover:text-gray-100 transition duration-200">Contact</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 bg-white shadow mt-10">
        <p class="text-gray-500 text-sm">© {{ date('Y') }} AuctoBid. All rights reserved.</p>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - AUCTOBID</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/AUCTOBID-Favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-medieval-cream min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto p-6">
        @yield('content')
    </div>
</body>
</html>

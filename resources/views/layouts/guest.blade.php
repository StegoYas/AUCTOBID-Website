<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Kingdom of AUCTOBID</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/AUCTOBID-Favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700&family=Uncial+Antiqua&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-medieval-cream bg-parchment-texture min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Background Decor (Optional) -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-10">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-medieval-gold rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-medieval-brown rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md mx-auto p-6 relative z-10 animate-fade-in">
        @yield('content')
    </div>
</body>
</html>

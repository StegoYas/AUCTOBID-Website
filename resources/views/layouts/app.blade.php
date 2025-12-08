<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AUCTOBID') - Sistem Lelang Online</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/AUCTOBID-Favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-medieval-cream min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Logo -->
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/AUCTOBID-Logo.png') }}" alt="AUCTOBID" class="h-10 w-auto">
                    <span class="font-cinzel text-xl font-bold text-white">AUCTOBID</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-line mr-3 text-lg"></i>
                    Dashboard
                </a>
                
                @if(auth()->user()->isAdmin())
                <div class="mt-6 mb-2">
                    <span class="px-4 text-xs font-cinzel font-semibold text-medieval-brown/50 uppercase tracking-wider">Admin</span>
                </div>
                
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="ri-user-line mr-3 text-lg"></i>
                    Pengguna
                </a>
                
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="ri-folder-line mr-3 text-lg"></i>
                    Kategori
                </a>
                
                <a href="{{ route('conditions.index') }}" class="nav-link {{ request()->routeIs('conditions.*') ? 'active' : '' }}">
                    <i class="ri-shield-check-line mr-3 text-lg"></i>
                    Kondisi
                </a>
                
                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="ri-settings-3-line mr-3 text-lg"></i>
                    Pengaturan
                </a>
                
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="ri-file-chart-line mr-3 text-lg"></i>
                    Laporan
                </a>
                @endif
                
                <div class="mt-6 mb-2">
                    <span class="px-4 text-xs font-cinzel font-semibold text-medieval-brown/50 uppercase tracking-wider">Operasional</span>
                </div>
                
                <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                    <i class="ri-archive-line mr-3 text-lg"></i>
                    Barang
                </a>
                
                <a href="{{ route('auctions.index') }}" class="nav-link {{ request()->routeIs('auctions.*') ? 'active' : '' }}">
                    <i class="ri-hammer-line mr-3 text-lg"></i>
                    Lelang
                </a>
            </nav>
            
            <!-- Footer -->
            <div class="sidebar-footer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-medieval-gold/30 flex items-center justify-center">
                        <i class="ri-user-line text-medieval-brown"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-medieval-slate truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-medieval-slate/60 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <header class="main-header">
                <div>
                    <h1 class="text-xl font-cinzel font-semibold text-medieval-brown">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-medieval-slate hover:text-medieval-brown transition-colors">
                        <i class="ri-notification-3-line text-xl"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-medieval-slate hover:text-medieval-brown transition-colors">
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak class="dropdown">
                            <a href="#" class="dropdown-item">
                                <i class="ri-user-line mr-2"></i> Profil
                            </a>
                            <hr class="my-1 border-medieval-gold/10">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left text-red-600">
                                    <i class="ri-logout-box-line mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success animate-fadeIn">
                    <i class="ri-checkbox-circle-line mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-error animate-fadeIn">
                    <i class="ri-error-warning-line mr-2"></i>
                    {{ session('error') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-error animate-fadeIn">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>

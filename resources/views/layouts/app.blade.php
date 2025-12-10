<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Kingdom of AUCTOBID</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/AUCTOBID-Favicon.png') }}">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300&family=Uncial+Antiqua&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-medieval-cream bg-parchment-texture text-medieval-slate font-merriweather antialiased h-screen flex overflow-hidden">

    <!-- SIDEBAR: Royal Navigation Scroll -->
    <aside class="w-72 bg-gradient-to-b from-medieval-brown to-medieval-dark-brown text-medieval-cream flex flex-col shadow-2xl relative z-20 border-r-4 border-medieval-gold border-double">
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-center border-b border-medieval-gold/30 bg-black/10 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/parchment-bg.svg')] opacity-10 mix-blend-overlay"></div>
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 relative z-10 group">
                <img src="{{ asset('images/AUCTOBID-Favicon.png') }}" alt="Logo" class="h-10 w-auto group-hover:scale-110 transition-transform duration-300 drop-shadow-lg">
                <span class="font-cinzel text-xl font-bold tracking-widest text-[#D4AF37] group-hover:text-white transition-colors drop-shadow-md">
                    AUCTOBID
                </span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 custom-scrollbar">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-castle-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Dashboard</span>
            </a>

            @if(auth()->user()->isAdmin())
            <div class="mt-8 mb-2 px-4">
                <div class="flex items-center">
                    <div class="h-px bg-medieval-gold/30 flex-1"></div>
                    <span class="px-2 text-[10px] font-uncial text-[#D4AF37]/70 tracking-[0.2em] uppercase">
                        Administrasi
                    </span>
                    <div class="h-px bg-medieval-gold/30 flex-1"></div>
                </div>
            </div>

            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-group-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Penduduk</span>
            </a>
            
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-book-mark-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Kategori Item</span>
            </a>

            <a href="{{ route('conditions.index') }}" class="nav-link {{ request()->routeIs('conditions.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-shield-star-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Kondisi Barang</span>
            </a>

            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-quill-pen-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Arsip Laporan</span>
            </a>
            
            <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-settings-4-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Pengaturan</span>
            </a>
            @endif

            <div class="mt-8 mb-2 px-4">
                <div class="flex items-center">
                    <div class="h-px bg-medieval-gold/30 flex-1"></div>
                    <span class="px-2 text-[10px] font-uncial text-[#D4AF37]/70 tracking-[0.2em] uppercase">
                        Operasional
                    </span>
                    <div class="h-px bg-medieval-gold/30 flex-1"></div>
                </div>
            </div>

            <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-treasure-map-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Inventaris</span>
            </a>

            <a href="{{ route('auctions.index') }}" class="nav-link {{ request()->routeIs('auctions.*') ? 'active' : '' }} text-white group flex items-center px-4 py-3 rounded-lg transition-all duration-200">
                <i class="ri-auction-line mr-3 text-lg group-hover:text-[#D4AF37]"></i>
                <span class="font-cinzel font-medium">Meja Lelang</span>
            </a>
        </nav>

        <!-- Sidebar Footer (User Info) -->
        <div class="p-4 bg-black/20 border-t border-medieval-gold/30">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-medieval-gold/20 border border-medieval-gold flex items-center justify-center shadow-inner-parchment">
                    <i class="ri-user-star-line text-[#D4AF37]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-cinzel font-bold text-medieval-cream truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-[#D4AF37]/70 uppercase font-merriweather tracking-wider">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 bg-transparent relative">
        <!-- Overlay Texture -->
        <div class="absolute inset-0 z-0 pointer-events-none bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-medieval-gold/5 via-transparent to-transparent"></div>

        <!-- Header -->
        <header class="h-20 bg-white/60 backdrop-blur-sm border-b border-medieval-gold/30 flex items-center justify-between px-8 shadow-sm z-10 sticky top-0">
            <div class="flex items-center">
                <h1 class="text-2xl font-cinzel font-bold text-[#D4AF37] flex items-center">
                    <span class="text-[#D4AF37] mr-3 opacity-80 text-3xl">✦</span>
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-medieval-brown hover:text-[#D4AF37] transition-colors group">
                        <i class="ri-notification-3-fill text-xl drop-shadow-sm group-hover:scale-110 transition-transform"></i>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-medieval-crimson rounded-full border border-white animate-pulse"></span>
                    </button>

                    <!-- Notification Panel -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="absolute right-0 mt-4 w-80 bg-[#FFF8DC] border-2 border-[#D4AF37] rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.3)] z-50 overflow-hidden bg-parchment-texture" 
                         x-cloak>
                        
                        <div class="px-4 py-3 border-b-2 border-[#D4AF37]/30 bg-[#D4AF37]/10 flex justify-between items-center">
                            <h3 class="font-cinzel font-bold text-[#5D2E0C]">Pemberitahuan Kerajaan</h3>
                            <span class="text-xs font-merriweather bg-[#D4AF37] text-white px-2 py-0.5 rounded-full">Baru</span>
                        </div>
                        
                        <div class="max-h-64 overflow-y-auto custom-scrollbar">
                            <!-- Empty State -->
                            <div class="p-6 text-center text-[#5D2E0C]/60">
                                <i class="ri-mail-open-line text-3xl mb-2 opacity-50"></i>
                                <p class="text-sm font-merriweather italic">Tidak ada kabar terbaru dari kerajaan.</p>
                            </div>
                        </div>
                        
                        <div class="p-2 border-t border-[#D4AF37]/20 bg-[#D4AF37]/5 text-center">
                            <a href="#" class="text-xs font-cinzel font-bold text-[#5D2E0C] hover:text-[#D4AF37] transition-colors">Lihat Semua Arsip</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-medieval-brown hover:text-medieval-dark-brown transition-colors font-cinzel font-semibold group">
                        <span>{{ auth()->user()->name }}</span>
                        <i class="ri-arrow-down-s-fill group-hover:translate-y-0.5 transition-transform"></i>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-48 bg-medieval-cream rounded-xl shadow-medieval border-2 border-medieval-gold/50 py-1 z-50 overflow-hidden" 
                         x-cloak>
                        
                        <div class="px-4 py-2 border-b border-medieval-gold/20 bg-medieval-gold/10">
                            <span class="text-xs text-medieval-slate uppercase font-bold tracking-wider">Akun</span>
                        </div>
                        
                        <a href="{{ route('users.show', auth()->user()->id) }}" class="block px-4 py-2 text-sm text-medieval-brown hover:bg-medieval-brown hover:text-white transition-colors">
                            <i class="ri-user-settings-line mr-2"></i> Profil
                        </a>
                        
                        <div class="border-t border-medieval-gold/20 my-1"></div>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-medieval-crimson hover:bg-medieval-crimson hover:text-white transition-colors font-bold">
                                <i class="ri-logout-box-r-line mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-8 custom-scrollbar relative z-0">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success animate-fade-in mb-6 border-l-4 border-l-medieval-forest shadow-md" role="alert">
                    <i class="ri-checkbox-circle-fill text-xl mr-3"></i>
                    <div>
                        <span class="font-bold block font-cinzel text-lg">Berhasil!</span>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error animate-fade-in mb-6 border-l-4 border-l-medieval-crimson shadow-md" role="alert">
                    <i class="ri-close-circle-fill text-xl mr-3"></i>
                    <div>
                        <span class="font-bold block font-cinzel text-lg">Kesalahan!</span>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Actual Page Content -->
            @yield('content')
            
            <!-- Footer -->
            <footer class="mt-12 pt-6 border-t border-medieval-gold/20 text-center text-sm text-medieval-slate/50 font-merriweather italic pb-4">
                <p>&copy; {{ date('Y') }} AUCTOBID Kingdom. All rights reserved.</p>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>

@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Bangsawan')

@section('content')
<!-- Stats Kingdom Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
    <div class="relative bg-white rounded-xl p-6 shadow-medieval border-2 border-medieval-gold/30 group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute -top-3 -right-3 w-10 h-10 bg-medieval-gold rotate-45 border-4 border-medieval-cream shadow-md z-10 hidden group-hover:block transition-all"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold">
                <i class="ri-user-star-line text-2xl text-medieval-brown"></i>
            </div>
            <span class="text-xs font-cinzel font-bold text-medieval-slate/50 uppercase tracking-widest">Warga</span>
        </div>
        <div class="text-3xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">{{ number_format($stats['total_users']) }}</div>
        <div class="mt-1 text-sm font-merriweather text-medieval-slate/70">Total Populasi</div>
        
        @if($stats['pending_users'] > 0)
        <div class="mt-4 pt-4 border-t border-medieval-gold/20">
            <span class="badge badge-pending animate-pulse-gold inline-flex">
                <i class="ri-time-line mr-1"></i>
                {{ $stats['pending_users'] }} Menunggu Titah
            </span>
        </div>
        @endif
    </div>
    
    <div class="relative bg-white rounded-xl p-6 shadow-medieval border-2 border-medieval-gold/30 group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold">
                <i class="ri-treasure-map-line text-2xl text-medieval-brown"></i>
            </div>
            <span class="text-xs font-cinzel font-bold text-medieval-slate/50 uppercase tracking-widest">Harta</span>
        </div>
        <div class="text-3xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">{{ number_format($stats['total_items']) }}</div>
        <div class="mt-1 text-sm font-merriweather text-medieval-slate/70">Total Inventaris</div>
        
        @if($stats['pending_items'] > 0)
        <div class="mt-4 pt-4 border-t border-medieval-gold/20">
            <span class="badge badge-pending animate-pulse-gold inline-flex">
                <i class="ri-shield-check-line mr-1"></i>
                {{ $stats['pending_items'] }} Perlu Inspeksi
            </span>
        </div>
        @endif
    </div>
    
    <div class="relative bg-white rounded-xl p-6 shadow-medieval border-2 border-medieval-gold/30 group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold">
                <i class="ri-auction-line text-2xl text-medieval-brown"></i>
            </div>
            <span class="text-xs font-cinzel font-bold text-medieval-slate/50 uppercase tracking-widest">Lelang</span>
        </div>
        <div class="text-3xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">{{ number_format($stats['active_auctions']) }}</div>
        <div class="mt-1 text-sm font-merriweather text-medieval-slate/70">Lelang Aktif</div>
        
        <div class="mt-4 pt-4 border-t border-medieval-gold/20">
            <span class="text-xs text-medieval-forest font-bold flex items-center">
                <i class="ri-arrow-up-circle-line mr-1"></i> Sedang Berlangsung
            </span>
        </div>
    </div>
    
    <div class="relative bg-white rounded-xl p-6 shadow-medieval border-2 border-medieval-gold/30 group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold">
                <i class="ri-trophy-line text-2xl text-medieval-brown"></i>
            </div>
            <span class="text-xs font-cinzel font-bold text-medieval-slate/50 uppercase tracking-widest">Selesai</span>
        </div>
        <div class="text-3xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">{{ number_format($stats['completed_auctions']) }}</div>
        <div class="mt-1 text-sm font-merriweather text-medieval-slate/70">Transaksi Sukses</div>
        
        <div class="mt-4 pt-4 border-t border-medieval-gold/20">
            <span class="text-xs text-medieval-slate flex items-center">
                <i class="ri-history-line mr-1"></i> Data Historis
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pending Users Scroll -->
    @if(auth()->user()->isAdmin() && $pendingUsers->count() > 0)
    <x-medieval-card title="Petisi Warga Baru" icon="ri-mail-open-line">
        <x-slot name="actions">
            <a href="{{ route('users.pending') }}" class="text-xs font-cinzel font-bold text-medieval-gold hover:text-medieval-brown transition-colors">
                Lihat Semua Petisi →
            </a>
        </x-slot>

        <div class="overflow-hidden rounded-lg border border-medieval-gold/20">
            <div class="divide-y divide-medieval-gold/10 bg-white/50">
                @foreach($pendingUsers as $pendingUser)
                <div class="p-4 flex items-center justify-between hover:bg-medieval-gold/5 transition-colors group">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-medieval-brown text-white flex items-center justify-center font-cinzel font-bold border-2 border-medieval-gold shadow-sm group-hover:scale-110 transition-transform">
                            {{ substr($pendingUser->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-medieval-brown font-cinzel">{{ $pendingUser->name }}</p>
                            <p class="text-xs text-medieval-slate/60">{{ $pendingUser->email }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 opacity-80 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('users.approve', $pendingUser) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-8 h-8 rounded-full bg-medieval-forest text-white flex items-center justify-center hover:bg-green-700 shadow-md" title="Setujui">
                                <i class="ri-quill-pen-line"></i>
                            </button>
                        </form>
                        <a href="{{ route('users.show', $pendingUser) }}" class="w-8 h-8 rounded-full bg-medieval-gold text-white flex items-center justify-center hover:bg-medieval-light-gold shadow-md" title="Lihat">
                            <i class="ri-eye-line"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </x-medieval-card>
    @endif
    
    <!-- Active Auctions Scroll -->
    <x-medieval-card title="Meja Lelang Aktif" icon="ri-hammer-fill">
        <x-slot name="actions">
            <a href="{{ route('auctions.index') }}" class="text-xs font-cinzel font-bold text-medieval-gold hover:text-medieval-brown transition-colors">
                Ke Ruang Lelang →
            </a>
        </x-slot>

        <div class="overflow-hidden rounded-lg border border-medieval-gold/20">
            @if($activeAuctions->count() > 0)
            <div class="divide-y divide-medieval-gold/10 bg-white/50">
                @foreach($activeAuctions as $auction)
                <div class="p-4 flex items-center justify-between hover:bg-medieval-gold/5 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            @if($auction->item->primaryImage)
                                <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                                     alt="{{ $auction->item->name }}" 
                                     class="w-12 h-12 rounded-lg object-cover border border-medieval-gold/50 shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold/50">
                                    <i class="ri-image-line text-medieval-brown"></i>
                                </div>
                            @endif
                            <div class="absolute -top-2 -right-2 bg-medieval-crimson text-white text-[10px] px-1.5 py-0.5 rounded-full shadow-sm animate-pulse">
                                Live
                            </div>
                        </div>
                        <div>
                            <p class="font-bold text-medieval-slate font-cinzel text-sm">{{ Str::limit($auction->item->name, 25) }}</p>
                            <p class="text-sm text-medieval-gold font-bold font-merriweather">
                                Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-wider text-medieval-slate/50 font-bold">Sisa Waktu</p>
                        <p class="text-sm font-bold text-medieval-brown font-mono">{{ $auction->time_remaining }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-8 text-center text-medieval-slate/40 flex flex-col items-center justify-center min-h-[200px]">
                <i class="ri-hammer-line text-5xl mb-4 opacity-50"></i>
                <p class="font-cinzel text-lg">Meja Lelang Sepi</p>
                <p class="text-sm">Belum ada aktivitas lelang saat ini.</p>
            </div>
            @endif
        </div>
    </x-medieval-card>
    
    <!-- Recent Items Scroll -->
    <x-medieval-card title="Inventaris Terbaru" icon="ri-archive-drawer-line">
        <x-slot name="actions">
            <a href="{{ route('items.index') }}" class="text-xs font-cinzel font-bold text-medieval-gold hover:text-medieval-brown transition-colors">
                Buka Gudang →
            </a>
        </x-slot>

        <div class="overflow-hidden rounded-lg border border-medieval-gold/20">
            <div class="divide-y divide-medieval-gold/10 bg-white/50">
                @foreach($recentItems as $item)
                <div class="p-4 flex items-center justify-between hover:bg-medieval-gold/5 transition-colors">
                    <div class="flex items-center space-x-4">
                        @if($item->primaryImage)
                            <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                                 class="w-10 h-10 rounded object-cover border border-medieval-gold/30">
                        @else
                            <div class="w-10 h-10 rounded bg-medieval-gold/10 flex items-center justify-center border border-medieval-gold/30">
                                <i class="ri-box-3-line text-medieval-brown"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-medieval-slate text-sm">{{ Str::limit($item->name, 25) }}</p>
                            <span class="text-xs text-medieval-slate/60 italic">{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                        </div>
                    </div>
                    <span class="badge badge-{{ $item->status }} text-[10px]">{{ ucfirst($item->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </x-medieval-card>
</div>
@endsection

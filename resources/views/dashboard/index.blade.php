@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="ri-user-line text-2xl"></i>
        </div>
        <div class="stat-card-value">{{ number_format($stats['total_users']) }}</div>
        <div class="stat-card-label">Total Pengguna</div>
        @if($stats['pending_users'] > 0)
        <div class="mt-2">
            <span class="badge badge-pending">{{ $stats['pending_users'] }} menunggu persetujuan</span>
        </div>
        @endif
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="ri-archive-line text-2xl"></i>
        </div>
        <div class="stat-card-value">{{ number_format($stats['total_items']) }}</div>
        <div class="stat-card-label">Total Barang</div>
        @if($stats['pending_items'] > 0)
        <div class="mt-2">
            <span class="badge badge-pending">{{ $stats['pending_items'] }} menunggu persetujuan</span>
        </div>
        @endif
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="ri-hammer-line text-2xl"></i>
        </div>
        <div class="stat-card-value">{{ number_format($stats['active_auctions']) }}</div>
        <div class="stat-card-label">Lelang Aktif</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">
            <i class="ri-checkbox-circle-line text-2xl"></i>
        </div>
        <div class="stat-card-value">{{ number_format($stats['completed_auctions']) }}</div>
        <div class="stat-card-label">Lelang Selesai</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pending Users -->
    @if(auth()->user()->isAdmin() && $pendingUsers->count() > 0)
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-user-add-line mr-2"></i>
                Pendaftaran Menunggu Persetujuan
            </h3>
            <a href="{{ route('users.pending') }}" class="text-sm text-medieval-gold hover:text-medieval-brown">
                Lihat Semua →
            </a>
        </div>
        <div class="card-body p-0">
            <div class="divide-y divide-medieval-gold/10">
                @foreach($pendingUsers as $pendingUser)
                <div class="flex items-center justify-between p-4 hover:bg-medieval-parchment/30">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-medieval-gold/20 flex items-center justify-center">
                            <i class="ri-user-line text-medieval-brown"></i>
                        </div>
                        <div>
                            <p class="font-medium text-medieval-slate">{{ $pendingUser->name }}</p>
                            <p class="text-sm text-medieval-slate/60">{{ $pendingUser->email }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('users.approve', $pendingUser) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="ri-check-line"></i>
                            </button>
                        </form>
                        <a href="{{ route('users.show', $pendingUser) }}" class="btn btn-outline btn-sm">
                            <i class="ri-eye-line"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    <!-- Active Auctions -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-hammer-line mr-2"></i>
                Lelang Aktif
            </h3>
            <a href="{{ route('auctions.index') }}" class="text-sm text-medieval-gold hover:text-medieval-brown">
                Lihat Semua →
            </a>
        </div>
        <div class="card-body p-0">
            @if($activeAuctions->count() > 0)
            <div class="divide-y divide-medieval-gold/10">
                @foreach($activeAuctions as $auction)
                <div class="flex items-center justify-between p-4 hover:bg-medieval-parchment/30">
                    <div class="flex items-center space-x-3">
                        @if($auction->item->primaryImage)
                        <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                             alt="{{ $auction->item->name }}" 
                             class="w-12 h-12 rounded-lg object-cover">
                        @else
                        <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center">
                            <i class="ri-image-line text-medieval-brown"></i>
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-medieval-slate">{{ Str::limit($auction->item->name, 30) }}</p>
                            <p class="text-sm text-medieval-gold font-semibold">
                                Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-medieval-slate/60">Berakhir dalam</p>
                        <p class="text-sm font-medium text-medieval-brown">{{ $auction->time_remaining }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-8 text-center text-medieval-slate/60">
                <i class="ri-hammer-line text-4xl mb-2"></i>
                <p>Tidak ada lelang aktif</p>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Items -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-archive-line mr-2"></i>
                Barang Terbaru
            </h3>
            <a href="{{ route('items.index') }}" class="text-sm text-medieval-gold hover:text-medieval-brown">
                Lihat Semua →
            </a>
        </div>
        <div class="card-body p-0">
            <div class="divide-y divide-medieval-gold/10">
                @foreach($recentItems as $item)
                <div class="flex items-center justify-between p-4 hover:bg-medieval-parchment/30">
                    <div class="flex items-center space-x-3">
                        @if($item->primaryImage)
                        <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                             alt="{{ $item->name }}" 
                             class="w-12 h-12 rounded-lg object-cover">
                        @else
                        <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center">
                            <i class="ri-image-line text-medieval-brown"></i>
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-medieval-slate">{{ Str::limit($item->name, 30) }}</p>
                            <p class="text-sm text-medieval-slate/60">{{ $item->category->name ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

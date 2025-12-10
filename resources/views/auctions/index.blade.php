@extends('layouts.app')

@section('title', 'Daftar Lelang')
@section('page-title', 'Meja Lelang')

@section('content')
<x-medieval-card title="Jadwal & Meja Lelang" icon="ri-auction-fill">
    <x-slot name="actions">
        <a href="{{ route('auctions.create') }}" class="btn btn-primary btn-sm flex items-center shadow-gold hover:shadow-lg transition-all">
            <i class="ri-add-circle-line mr-2 text-lg"></i>
            <span class="font-cinzel font-bold text-[#F4C430]">Buka Lelang Baru</span>
        </a>
    </x-slot>

    <div class="mb-6 p-4 bg-medieval-parchment/30 rounded-lg border border-medieval-gold/20">
        <form action="{{ route('auctions.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 relative min-w-[200px]">
                <i class="ri-search-2-line absolute left-3 top-1/2 transform -translate-y-1/2 text-medieval-slate/50"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari barang lelang..." 
                       class="w-full pl-10 pr-4 py-2 rounded border border-medieval-gold/30 bg-white/80 focus:ring-2 focus:ring-medieval-gold focus:border-transparent font-merriweather text-sm">
            </div>
            
            <select name="status" class="py-2 px-4 rounded border border-medieval-gold/30 bg-white/80 font-cinzel text-sm focus:ring-2 focus:ring-medieval-gold">
                <option value="all">Semua Status</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Berlangsung</option>
                <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            
            <x-medieval-button type="primary" size="sm" icon="ri-filter-3-line">Filter</x-medieval-button>
        </form>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-medieval-gold/30 shadow-inner-parchment">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th class="w-1/3">Barang Lelang</th>
                    <th>Penawaran Terkini</th>
                    <th class="text-center">Total Bid</th>
                    <th>Status</th>
                    <th>Batas Waktu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $auction)
                <tr class="{{ $auction->status == 'active' ? 'bg-medieval-gold/5' : '' }}">
                    <td>
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                @if($auction->item && $auction->item->primaryImage)
                                <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                                     class="w-14 h-14 rounded-lg object-cover border-2 {{ $auction->status == 'active' ? 'border-medieval-gold shadow-gold' : 'border-medieval-gold/20' }}">
                                @else
                                <div class="w-14 h-14 rounded-lg bg-medieval-gold/10 flex items-center justify-center border-2 border-medieval-gold/20">
                                    <i class="ri-image-line text-medieval-brown/50"></i>
                                </div>
                                @endif
                                
                                @if($auction->status == 'active')
                                <div class="absolute -top-1 -right-1 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-medieval-crimson opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-medieval-crimson"></span>
                                </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-cinzel font-bold text-medieval-brown text-sm">{{ Str::limit($auction->item->name ?? 'Unknown Item', 30) }}</p>
                                <p class="text-[10px] text-medieval-slate/60 font-merriweather italic mt-0.5">
                                    {{ $auction->item->category->name ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="font-cinzel font-bold text-lg {{ $auction->status == 'active' ? 'text-medieval-gold drop-shadow-sm' : 'text-medieval-slate' }}">
                        Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                    </td>
                    <td class="text-center font-mono text-medieval-brown">
                        {{ $auction->total_bids }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $auction->status }} font-bold text-[10px] uppercase tracking-wider shadow-sm">
                            {{ ucfirst($auction->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center text-sm font-merriweather">
                            @if($auction->isActive())
                                <i class="ri-timer-flash-line mr-2 text-medieval-crimson animate-pulse"></i>
                                <span class="text-medieval-crimson font-bold">{{ $auction->time_remaining }}</span>
                            @else
                                <i class="ri-calendar-event-line mr-2 text-medieval-slate/50"></i>
                                <span class="text-medieval-slate/70">{{ $auction->end_time->format('d M Y H:i') }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('auctions.show', $auction) }}" class="p-2 rounded-full hover:bg-medieval-gold/10 text-medieval-brown transition-colors" title="Lihat Meja">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            
                            @if($auction->status == 'active')
                            <form action="{{ route('auctions.close', $auction) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Baginda yakin ingin mengakhiri lelang ini sekarang?')">
                                @csrf
                                <button type="submit" class="p-2 rounded-full hover:bg-medieval-crimson/10 text-medieval-crimson transition-colors" title="Tutup Lelang">
                                    <i class="ri-gavel-line text-lg"></i>
                                </button>
                            </form>
                            @elseif($auction->status == 'scheduled')
                            <form action="{{ route('auctions.start', $auction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 rounded-full hover:bg-medieval-forest/10 text-medieval-forest transition-colors" title="Mulai Lelang">
                                    <i class="ri-play-circle-line text-lg"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center text-medieval-slate/40">
                            <i class="ri-hammer-line text-5xl mb-4 opacity-50"></i>
                            <p class="font-cinzel text-xl">Tidak Ada Lelang</p>
                            <p class="text-sm">Jadwal lelang kosong atau belum ada barang.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($auctions->hasPages())
    <div class="mt-6">
        {{ $auctions->links() }}
    </div>
    @endif
</x-medieval-card>
@endsection

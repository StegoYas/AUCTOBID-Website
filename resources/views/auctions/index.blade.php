@extends('layouts.app')

@section('title', 'Daftar Lelang')
@section('page-title', 'Daftar Lelang')

@section('content')
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-hammer-line mr-2"></i>
            Semua Lelang
        </h3>
        <a href="{{ route('auctions.create') }}" class="btn btn-primary btn-sm">
            <i class="ri-add-line mr-2"></i>
            Buka Lelang Baru
        </a>
    </div>
    
    <div class="p-4 border-b border-medieval-gold/10">
        <form action="{{ route('auctions.index') }}" method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama barang..." 
                   class="form-input flex-1 min-w-[200px]">
            <select name="status" class="form-input w-40">
                <option value="all">Semua Status</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="ri-search-line"></i>
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga Saat Ini</th>
                    <th>Total Bid</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $auction)
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            @if($auction->item && $auction->item->primaryImage)
                            <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                                 class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center">
                                <i class="ri-image-line text-medieval-brown"></i>
                            </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $auction->item->name ?? 'N/A' }}</p>
                                <p class="text-xs text-medieval-slate/60">{{ $auction->item->category->name ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="font-semibold text-medieval-gold">
                        Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                    </td>
                    <td>{{ $auction->total_bids }}</td>
                    <td><span class="badge badge-{{ $auction->status }}">{{ ucfirst($auction->status) }}</span></td>
                    <td>
                        @if($auction->isActive())
                        <span class="text-green-600">{{ $auction->time_remaining }}</span>
                        @else
                        {{ $auction->end_time->format('d M Y H:i') }}
                        @endif
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline btn-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if($auction->status == 'active')
                            <form action="{{ route('auctions.close', $auction) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin ingin menutup lelang ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="ri-stop-line"></i>
                                </button>
                            </form>
                            @elseif($auction->status == 'scheduled')
                            <form action="{{ route('auctions.start', $auction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="ri-play-line"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-medieval-slate/60">
                        Tidak ada data lelang
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($auctions->hasPages())
    <div class="card-footer">
        {{ $auctions->links() }}
    </div>
    @endif
</div>
@endsection

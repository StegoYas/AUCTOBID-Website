@extends('layouts.app')

@section('title', 'Detail Lelang')
@section('page-title', 'Detail Lelang')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Item Info -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-cinzel font-semibold text-medieval-brown">
                    {{ $auction->item->name ?? 'Barang Lelang' }}
                </h3>
                <span class="badge badge-{{ $auction->status }}">{{ ucfirst($auction->status) }}</span>
            </div>
            
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($auction->item && $auction->item->primaryImage)
                    <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                         class="w-full rounded-lg">
                    @else
                    <div class="w-full h-64 bg-medieval-parchment rounded-lg flex items-center justify-center">
                        <i class="ri-image-line text-4xl text-medieval-slate/30"></i>
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-medieval-slate/60">Pemilik</span>
                            <p class="font-medium">{{ $auction->item->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-medieval-slate/60">Kategori</span>
                            <p class="font-medium">{{ $auction->item->category->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-medieval-slate/60">Kondisi</span>
                            <p class="font-medium">{{ $auction->item->condition->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-medieval-slate/60">Deskripsi</span>
                            <p class="text-sm">{{ Str::limit($auction->item->description, 200) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bid History -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-cinzel font-semibold text-medieval-brown">
                    <i class="ri-history-line mr-2"></i>
                    Riwayat Tawaran
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="table-medieval">
                    <thead>
                        <tr>
                            <th>Penawar</th>
                            <th>Jumlah</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auction->bids()->with('user')->latest()->take(20)->get() as $bid)
                        <tr class="{{ $loop->first ? 'bg-green-50' : '' }}">
                            <td>
                                <div class="flex items-center space-x-2">
                                    @if($loop->first)
                                    <i class="ri-medal-line text-medieval-gold"></i>
                                    @endif
                                    <span>{{ $bid->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="font-semibold {{ $loop->first ? 'text-green-600' : '' }}">
                                Rp {{ number_format($bid->amount, 0, ',', '.') }}
                            </td>
                            <td>{{ $bid->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-medieval-slate/60">
                                Belum ada tawaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Price Card -->
        <div class="card">
            <div class="card-body text-center">
                <p class="text-sm text-medieval-slate/60">Harga Saat Ini</p>
                <p class="text-3xl font-cinzel font-bold text-medieval-gold mt-2">
                    Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                </p>
                
                <div class="grid grid-cols-2 gap-4 mt-6 text-center">
                    <div>
                        <p class="text-2xl font-bold text-medieval-brown">{{ $auction->total_bids }}</p>
                        <p class="text-sm text-medieval-slate/60">Total Bid</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-medieval-brown">{{ $auction->bids()->distinct('user_id')->count('user_id') }}</p>
                        <p class="text-sm text-medieval-slate/60">Penawar</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Auction Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-cinzel font-semibold text-medieval-brown">Informasi Lelang</h3>
            </div>
            <div class="card-body space-y-3">
                <div class="flex justify-between">
                    <span class="text-medieval-slate/60">Mulai</span>
                    <span>{{ $auction->start_time->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-medieval-slate/60">Berakhir</span>
                    <span>{{ $auction->end_time->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-medieval-slate/60">Harga Awal</span>
                    <span>Rp {{ number_format($auction->starting_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-medieval-slate/60">Kenaikan Min.</span>
                    <span>Rp {{ number_format($auction->minimum_bid_increment, 0, ',', '.') }}</span>
                </div>
                @if($auction->winner)
                <div class="pt-3 mt-3 border-t border-medieval-gold/20">
                    <span class="text-medieval-slate/60">Pemenang</span>
                    <p class="font-semibold text-green-600 mt-1">
                        <i class="ri-trophy-line mr-1"></i>
                        {{ $auction->winner->name }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <div class="card-body space-y-3">
                <a href="{{ route('auctions.index') }}" class="btn btn-outline w-full">
                    <i class="ri-arrow-left-line mr-2"></i> Kembali
                </a>
                
                @if($auction->status == 'scheduled')
                <form action="{{ route('auctions.start', $auction) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-full">
                        <i class="ri-play-line mr-2"></i> Mulai Lelang
                    </button>
                </form>
                @endif
                
                @if($auction->status == 'active')
                <form action="{{ route('auctions.close', $auction) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menutup lelang ini?')">
                    @csrf
                    <button type="submit" class="btn btn-danger w-full">
                        <i class="ri-stop-line mr-2"></i> Tutup Lelang
                    </button>
                </form>
                @endif
                
                @if(in_array($auction->status, ['scheduled', 'active']))
                <form action="{{ route('auctions.cancel', $auction) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan lelang ini?')">
                    @csrf
                    <button type="submit" class="btn btn-outline w-full text-red-600 border-red-600 hover:bg-red-600 hover:text-white">
                        <i class="ri-close-circle-line mr-2"></i> Batalkan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

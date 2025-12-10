@extends('layouts.app')

@section('title', 'Detail Lelang')
@section('page-title', 'Detail Lelang')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Item Info -->
        <x-medieval-card 
            :title="$auction->item->name ?? 'Barang Lelang'"
            icon="ri-treasure-map-line"
            class="transform hover:scale-[1.005] transition-all duration-300"
        >
            <x-slot name="actions">
                <span class="badge badge-{{ $auction->status }} font-cinzel">{{ ucfirst($auction->status) }}</span>
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image Section -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-medieval-gold to-medieval-brown rounded-lg opacity-25 blur transition duration-1000 group-hover:opacity-75"></div>
                    <div class="relative rounded-lg overflow-hidden border-2 border-medieval-gold/30 shadow-inner bg-medieval-paper">
                        @if($auction->item && $auction->item->primaryImage)
                            <img src="{{ asset('storage/' . $auction->item->primaryImage->image_path) }}" 
                                 class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-700"
                                 alt="{{ $auction->item->name }}">
                        @else
                            <div class="w-full h-64 flex flex-col items-center justify-center bg-medieval-paper">
                                <i class="ri-image-line text-4xl text-medieval-brown/30 mb-2"></i>
                                <span class="text-medieval-brown/50 font-cinzel text-sm">Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                        
                        <!-- Decorative Corners -->
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-medieval-gold rounded-tl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-medieval-gold rounded-br-lg"></div>
                    </div>
                </div>
                
                <!-- Details -->
                <div class="space-y-4">
                    <div class="p-3 bg-medieval-paper/50 rounded-lg border border-medieval-gold/10">
                        <span class="text-xs font-cinzel text-medieval-brown uppercase tracking-widest">Pemilik</span>
                        <div class="flex items-center mt-1">
                            <div class="w-6 h-6 rounded-full bg-medieval-brown text-medieval-gold flex items-center justify-center text-xs mr-2 border border-medieval-gold">
                                {{ substr($auction->item->user->name ?? '?', 0, 1) }}
                            </div>
                            <p class="font-merriweather font-semibold text-medieval-slate">{{ $auction->item->user->name ?? 'Tidak Diketahui' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-medieval-paper/50 rounded-lg border border-medieval-gold/10">
                            <span class="text-xs font-cinzel text-medieval-brown uppercase tracking-widest">Kategori</span>
                            <p class="font-merriweather font-medium text-medieval-slate mt-1">
                                <i class="ri-price-tag-3-line text-medieval-gold mr-1"></i>
                                {{ $auction->item->category->name ?? '-' }}
                            </p>
                        </div>
                        <div class="p-3 bg-medieval-paper/50 rounded-lg border border-medieval-gold/10">
                            <span class="text-xs font-cinzel text-medieval-brown uppercase tracking-widest">Kondisi</span>
                            <p class="font-merriweather font-medium text-medieval-slate mt-1">
                                <i class="ri-heart-pulse-line text-medieval-gold mr-1"></i>
                                {{ $auction->item->condition->name ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-3 bg-medieval-paper/50 rounded-lg border border-medieval-gold/10">
                        <span class="text-xs font-cinzel text-medieval-brown uppercase tracking-widest">Deskripsi Barang</span>
                        <div class="mt-2 h-24 overflow-y-auto custom-scrollbar pr-2">
                            <p class="text-sm font-merriweather text-medieval-slate leading-relaxed">
                                {{ $auction->item->description ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-medieval-card>
        
        <!-- Bid History -->
        <x-medieval-card title="Riwayat Pertarungan Harga" icon="ri-sword-line">
            <div class="overflow-hidden rounded-lg border border-medieval-gold/20">
                <table class="w-full text-left">
                    <thead class="bg-medieval-brown text-medieval-gold font-cinzel text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">Ksatria Penawar</th>
                            <th class="px-4 py-3">Jumlah Penawaran</th>
                            <th class="px-4 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-medieval-gold/10 font-merriweather text-sm">
                        @forelse($auction->bids()->with('user')->latest()->take(20)->get() as $bid)
                        <tr class="hover:bg-medieval-gold/5 transition-colors {{ $loop->first ? 'bg-green-50/50' : '' }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    @if($loop->first)
                                    <i class="ri-vip-crown-fill text-medieval-gold animate-bounce"></i>
                                    @else
                                    <i class="ri-user-line text-medieval-slate/50"></i>
                                    @endif
                                    <span class="{{ $loop->first ? 'font-bold text-medieval-brown' : 'text-medieval-slate' }}">
                                        {{ $bid->user->name ?? 'Ksatria Misterius' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-cinzel font-bold {{ $loop->first ? 'text-green-700' : 'text-medieval-slate' }}">
                                Rp {{ number_format($bid->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-medieval-slate/60 text-xs">
                                {{ $bid->created_at->format('d M Y H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-medieval-slate/60 italic font-merriweather">
                                <i class="ri-windy-line text-2xl mb-2 block text-medieval-slate/40"></i>
                                Belum ada ksatria yang berani menawar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-medieval-card>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Price Card -->
        <div class="relative bg-gradient-to-b from-medieval-brown to-medieval-black rounded-xl p-1 shadow-gold">
            <div class="bg-medieval-parchment rounded-lg p-6 text-center relative overflow-hidden">
                <!-- Background Rune -->
                <div class="absolute inset-0 opacity-5 flex items-center justify-center pointer-events-none">
                    <i class="ri-copper-coin-line text-9xl"></i>
                </div>

                <p class="text-xs font-cinzel text-medieval-brown/70 uppercase tracking-widest mb-2">Harga Saat Ini</p>
                <div class="relative inline-block">
                    <p class="text-3xl lg:text-4xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">
                        Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                    </p>
                    <div class="h-1 w-full bg-gradient-to-r from-transparent via-medieval-gold to-transparent mt-1"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-8 pt-6 border-t border-medieval-gold/20 relative z-10">
                    <div class="text-center group cursor-default">
                        <div class="bg-medieval-gold/10 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-medieval-gold group-hover:text-white transition-colors duration-300">
                            <span class="font-cinzel font-bold">{{ $auction->total_bids }}</span>
                        </div>
                        <p class="text-xs uppercase font-cinzel text-medieval-slate/70">Total Bid</p>
                    </div>
                    <div class="text-center group cursor-default">
                        <div class="bg-medieval-gold/10 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-medieval-gold group-hover:text-white transition-colors duration-300">
                            <i class="ri-group-line"></i>
                        </div>
                        <p class="text-xs uppercase font-cinzel text-medieval-slate/70">Penawar</p>
                        <p class="text-xs font-bold text-medieval-brown">{{ $auction->bids()->distinct('user_id')->count('user_id') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Auction Info -->
        <x-medieval-card title="Maklumat Lelang" icon="ri-scroll-line">
            <div class="space-y-4 text-sm font-merriweather">
                <div class="flex justify-between items-center py-2 border-b border-medieval-gold/10">
                    <span class="text-medieval-slate/70 flex items-center"><i class="ri-calendar-line mr-2 text-medieval-gold"></i> Mulai</span>
                    <span class="font-semibold text-medieval-brown">{{ $auction->start_time->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-medieval-gold/10">
                    <span class="text-medieval-slate/70 flex items-center"><i class="ri-hourglass-line mr-2 text-medieval-gold"></i> Berakhir</span>
                    <span class="font-semibold text-medieval-brown">{{ $auction->end_time->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-medieval-gold/10">
                    <span class="text-medieval-slate/70 flex items-center"><i class="ri-coin-line mr-2 text-medieval-gold"></i> Harga Awal</span>
                    <span class="font-semibold text-medieval-brown">Rp {{ number_format($auction->starting_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-medieval-gold/10">
                    <span class="text-medieval-slate/70 flex items-center"><i class="ri-arrow-up-line mr-2 text-medieval-gold"></i> Min. Kenaikan</span>
                    <span class="font-semibold text-medieval-brown">Rp {{ number_format($auction->minimum_bid_increment, 0, ',', '.') }}</span>
                </div>
                @if($auction->winner)
                <div class="mt-4 bg-green-50 p-3 rounded border border-green-200 text-center">
                    <span class="text-xs uppercase tracking-widest text-green-800 font-cinzel block mb-1">Pemenang Diumumkan</span>
                    <p class="font-bold text-green-700 text-lg flex items-center justify-center">
                        <i class="ri-trophy-fill mr-2 text-yellow-500"></i>
                        {{ $auction->winner->name }}
                    </p>
                </div>
                @endif
            </div>
        </x-medieval-card>
        
        <!-- Actions -->
        <x-medieval-card class="bg-medieval-paper">
            <div class="space-y-3">
                <a href="{{ route('auctions.index') }}" class="block w-full">
                    <x-medieval-button type="outline" class="w-full justify-center">
                        <i class="ri-arrow-left-line mr-2"></i> Kembali ke Daftar
                    </x-medieval-button>
                </a>
                
                @if($auction->status == 'scheduled')
                <form action="{{ route('auctions.start', $auction) }}" method="POST">
                    @csrf
                    <x-medieval-button type="success" class="w-full justify-center">
                        <i class="ri-play-line mr-2"></i> Mulai Lelang
                    </x-medieval-button>
                </form>
                @endif
                
                @if($auction->status == 'active')
                <form action="{{ route('auctions.close', $auction) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menutup lelang ini?')">
                    @csrf
                    <x-medieval-button type="danger" class="w-full justify-center group">
                        <i class="ri-stop-line mr-2 group-hover:animate-pulse"></i> Tutup Lelang
                    </x-medieval-button>
                </form>
                @endif
                
                @if(in_array($auction->status, ['scheduled', 'active']))
                <form action="{{ route('auctions.cancel', $auction) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan lelang ini?')">
                    @csrf
                    <button type="submit" class="w-full py-2 px-4 rounded border-2 border-red-500 text-red-500 font-cinzel font-bold hover:bg-red-500 hover:text-white transition-all duration-300 uppercase tracking-widest text-xs flex items-center justify-center mt-2">
                        <i class="ri-close-circle-line mr-2"></i> Batalkan
                    </button>
                </form>
                @endif
            </div>
        </x-medieval-card>
    </div>
</div>
@endsection

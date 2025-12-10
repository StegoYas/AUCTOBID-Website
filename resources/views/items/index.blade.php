@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('page-title', 'Gudang Inventaris')

@section('content')
<x-medieval-card title="Daftar Barang Kerajaan" icon="ri-archive-line">
    <x-slot name="actions">
        <a href="{{ route('items.pending') }}" class="btn bg-medieval-night text-medieval-gold border border-medieval-gold hover:bg-medieval-brown text-sm px-3 py-1 rounded shadow-gold">
            <i class="ri-hourglass-2-line mr-1"></i>
            Menunggu Inspeksi
        </a>
    </x-slot>

    <div class="mb-6 p-4 bg-medieval-parchment/30 rounded-lg border border-medieval-gold/20">
        <form action="{{ route('items.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 relative min-w-[200px]">
                <i class="ri-search-2-line absolute left-3 top-1/2 transform -translate-y-1/2 text-medieval-slate/50"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari harta karun..." 
                       class="w-full pl-10 pr-4 py-2 rounded border border-medieval-gold/30 bg-white/80 focus:ring-2 focus:ring-medieval-gold focus:border-transparent font-merriweather text-sm">
            </div>
            
            <select name="status" class="py-2 px-4 rounded border border-medieval-gold/30 bg-white/80 font-cinzel text-sm focus:ring-2 focus:ring-medieval-gold">
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="auctioning" {{ request('status') == 'auctioning' ? 'selected' : '' }}>Dalam Lelang</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Terjual</option>
            </select>
            
            <x-medieval-button type="primary" size="sm" icon="ri-filter-3-line">Filter</x-medieval-button>
        </form>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-medieval-gold/30 shadow-inner-parchment">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th class="w-1/3">Artefak / Barang</th>
                    <th>Pemilik</th>
                    <th>Kategori</th>
                    <th>Taksiran Harga</th>
                    <th>Status</th>
                    <th class="text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                @if($item->primaryImage)
                                <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                                     class="w-14 h-14 rounded-lg object-cover border-2 border-medieval-gold/20 shadow-sm group-hover:scale-110 transition-transform">
                                @else
                                <div class="w-14 h-14 rounded-lg bg-medieval-gold/10 flex items-center justify-center border-2 border-medieval-gold/20">
                                    <i class="ri-image-line text-medieval-brown/50"></i>
                                </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-cinzel font-bold text-medieval-brown text-sm">{{ Str::limit($item->name, 30) }}</p>
                                <p class="text-xs text-medieval-slate/60 font-merriweather italic text-[10px] mt-0.5">ID: #{{ $item->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="font-merriweather text-sm">{{ $item->user->name ?? 'Anonim' }}</td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-medieval-brown/10 text-medieval-brown border border-medieval-brown/20">
                            <i class="ri-tag-line mr-1"></i> {{ $item->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="font-cinzel font-bold text-medieval-gold">
                        Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $item->status }} font-bold text-[10px] uppercase tracking-wider shadow-sm">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('items.show', $item) }}" class="p-2 rounded-full hover:bg-medieval-gold/10 text-medieval-brown transition-colors" title="Periksa Detail">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            @if($item->status == 'pending')
                            <form action="{{ route('items.approve', $item) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 rounded-full hover:bg-medieval-forest/10 text-medieval-forest transition-colors" title="Setujui">
                                    <i class="ri-check-double-line text-lg"></i>
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
                            <i class="ri-archive-drawer-line text-5xl mb-4 opacity-50"></i>
                            <p class="font-cinzel text-xl">Gudang Kosong</p>
                            <p class="text-sm">Tidak ada barang yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($items->hasPages())
    <div class="mt-6">
        {{ $items->links() }}
    </div>
    @endif
</x-medieval-card>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('page-title', 'Daftar Barang')

@section('content')
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-archive-line mr-2"></i>
            Semua Barang
        </h3>
        <a href="{{ route('items.pending') }}" class="btn btn-secondary btn-sm">
            <i class="ri-time-line mr-2"></i>
            Menunggu Persetujuan
        </a>
    </div>
    
    <div class="p-4 border-b border-medieval-gold/10">
        <form action="{{ route('items.index') }}" method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama barang..." 
                   class="form-input flex-1 min-w-[200px]">
            <select name="status" class="form-input w-40">
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="auctioning" {{ request('status') == 'auctioning' ? 'selected' : '' }}>Dilelang</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Terjual</option>
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
                    <th>Pemilik</th>
                    <th>Kategori</th>
                    <th>Harga Awal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            @if($item->primaryImage)
                            <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                                 class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <div class="w-12 h-12 rounded-lg bg-medieval-gold/20 flex items-center justify-center">
                                <i class="ri-image-line text-medieval-brown"></i>
                            </div>
                            @endif
                            <p class="font-medium">{{ Str::limit($item->name, 30) }}</p>
                        </div>
                    </td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td class="font-semibold">Rp {{ number_format($item->starting_price, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-outline btn-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if($item->status == 'pending')
                            <form action="{{ route('items.approve', $item) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="ri-check-line"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-medieval-slate/60">
                        Tidak ada data barang
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($items->hasPages())
    <div class="card-footer">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection

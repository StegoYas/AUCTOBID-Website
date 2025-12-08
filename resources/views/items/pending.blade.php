@extends('layouts.app')

@section('title', 'Barang Pending')
@section('page-title', 'Persetujuan Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-archive-line mr-2"></i>
            Barang Menunggu Persetujuan
        </h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
        @forelse($items as $item)
        <div class="bg-white rounded-xl border border-medieval-gold/20 overflow-hidden hover:shadow-lg transition-shadow">
            @if($item->primaryImage)
            <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                 class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-medieval-parchment flex items-center justify-center">
                <i class="ri-image-line text-4xl text-medieval-slate/30"></i>
            </div>
            @endif
            
            <div class="p-4">
                <h4 class="font-semibold text-medieval-brown truncate">{{ $item->name }}</h4>
                <p class="text-sm text-medieval-slate/60 mt-1">{{ $item->category->name ?? '-' }}</p>
                <p class="text-lg font-semibold text-medieval-gold mt-2">
                    Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                </p>
                
                <div class="mt-3 pt-3 border-t border-medieval-gold/10">
                    <p class="text-xs text-medieval-slate/60">Oleh: {{ $item->user->name ?? '-' }}</p>
                    <p class="text-xs text-medieval-slate/60">{{ $item->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="flex space-x-2 mt-4">
                    <a href="{{ route('items.show', $item) }}" class="btn btn-outline btn-sm flex-1">
                        Detail
                    </a>
                    <form action="{{ route('items.approve', $item) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm w-full">
                            <i class="ri-check-line"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-medieval-slate/60">
            <i class="ri-checkbox-circle-line text-4xl text-green-500"></i>
            <p class="mt-2">Tidak ada barang yang menunggu persetujuan</p>
        </div>
        @endforelse
    </div>
    
    @if($items->hasPages())
    <div class="card-footer">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection

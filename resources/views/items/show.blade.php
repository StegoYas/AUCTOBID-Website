@extends('layouts.app')

@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')

@section('content')
<div class="max-w-4xl">
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-archive-line mr-2"></i>
                {{ $item->name }}
            </h3>
            <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
        </div>
        
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Images -->
                <div>
                    @if($item->images->count() > 0)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}" 
                             class="w-full rounded-lg" id="mainImage">
                    </div>
                    @if($item->images->count() > 1)
                    <div class="flex space-x-2">
                        @foreach($item->images as $image)
                        <img src="{{ asset('storage/' . ($image->thumbnail_path ?? $image->image_path)) }}" 
                             class="w-16 h-16 rounded-lg object-cover cursor-pointer border-2 {{ $image->is_primary ? 'border-medieval-gold' : 'border-transparent' }}"
                             onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image_path) }}'">
                        @endforeach
                    </div>
                    @endif
                    @else
                    <div class="w-full h-64 bg-medieval-parchment rounded-lg flex items-center justify-center">
                        <span class="text-medieval-slate/60">Tidak ada gambar</span>
                    </div>
                    @endif
                </div>
                
                <!-- Details -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm text-medieval-slate/60">Pemilik</h4>
                        <p class="font-medium">{{ $item->user->name ?? '-' }}</p>
                        <p class="text-sm text-medieval-slate/60">{{ $item->user->email ?? '' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm text-medieval-slate/60">Kategori</h4>
                            <p class="font-medium">{{ $item->category->name ?? '-' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm text-medieval-slate/60">Kondisi</h4>
                            <p class="font-medium">{{ $item->condition->name ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm text-medieval-slate/60">Harga Awal</h4>
                            <p class="font-semibold text-medieval-gold text-lg">
                                Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm text-medieval-slate/60">Kenaikan Bid Min.</h4>
                            <p class="font-medium">
                                Rp {{ number_format($item->minimum_bid_increment, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm text-medieval-slate/60">Deskripsi</h4>
                        <p class="whitespace-pre-wrap">{{ $item->description }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm text-medieval-slate/60">Tanggal Diajukan</h4>
                        <p>{{ $item->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    @if($item->rejection_reason)
                    <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                        <h4 class="text-sm text-red-600 font-medium">Alasan Penolakan</h4>
                        <p class="text-red-800">{{ $item->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-footer flex flex-wrap gap-3">
            <a href="{{ route('items.index') }}" class="btn btn-outline">
                <i class="ri-arrow-left-line mr-2"></i> Kembali
            </a>
            
            @if($item->status == 'pending')
            <form action="{{ route('items.approve', $item) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="ri-check-line mr-2"></i> Setujui
                </button>
            </form>
            <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="btn btn-danger">
                <i class="ri-close-line mr-2"></i> Tolak
            </button>
            @endif
            
            @if($item->status == 'approved')
            <a href="{{ route('auctions.create', ['item_id' => $item->id]) }}" class="btn btn-primary">
                <i class="ri-hammer-line mr-2"></i> Buka Lelang
            </a>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('rejectModal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-cinzel font-semibold text-medieval-brown mb-4">Tolak Barang</h3>
        <form action="{{ route('items.reject', $item) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Alasan Penolakan</label>
                <textarea name="rejection_reason" rows="3" class="form-input" required 
                          placeholder="Jelaskan alasan penolakan..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn btn-danger">Tolak</button>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" 
                        class="btn btn-outline">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

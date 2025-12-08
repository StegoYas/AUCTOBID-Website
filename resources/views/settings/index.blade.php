@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-settings-3-line mr-2"></i>
                Pengaturan Sistem
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="commission_percentage" class="form-label">Persentase Komisi (%)</label>
                        <input type="number" name="commission_percentage" id="commission_percentage" 
                               value="{{ old('commission_percentage', $settings['commission_percentage']->value ?? 5) }}" 
                               step="0.1" min="0" max="50"
                               class="form-input w-40">
                        <p class="text-xs text-medieval-slate/60 mt-1">Komisi yang diambil dari harga akhir lelang</p>
                        @error('commission_percentage')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="default_auction_duration" class="form-label">Durasi Lelang Default (hari)</label>
                        <input type="number" name="default_auction_duration" id="default_auction_duration" 
                               value="{{ old('default_auction_duration', $settings['default_auction_duration']->value ?? 7) }}" 
                               min="1" max="30"
                               class="form-input w-40">
                        <p class="text-xs text-medieval-slate/60 mt-1">Durasi default saat membuka lelang baru</p>
                        @error('default_auction_duration')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="minimum_bid_increment" class="form-label">Kenaikan Bid Minimum (Rp)</label>
                        <input type="number" name="minimum_bid_increment" id="minimum_bid_increment" 
                               value="{{ old('minimum_bid_increment', $settings['minimum_bid_increment']->value ?? 10000) }}" 
                               min="1000"
                               class="form-input w-48">
                        <p class="text-xs text-medieval-slate/60 mt-1">Minimum kenaikan tawaran dari harga sebelumnya</p>
                        @error('minimum_bid_increment')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="max_item_images" class="form-label">Maksimal Gambar per Item</label>
                        <input type="number" name="max_item_images" id="max_item_images" 
                               value="{{ old('max_item_images', $settings['max_item_images']->value ?? 5) }}" 
                               min="1" max="10"
                               class="form-input w-40">
                        <p class="text-xs text-medieval-slate/60 mt-1">Jumlah maksimal foto yang dapat diupload per barang</p>
                        @error('max_item_images')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-medieval-gold/20">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

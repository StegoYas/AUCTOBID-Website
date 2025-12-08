@extends('layouts.app')

@section('title', 'Buka Lelang')
@section('page-title', 'Buka Lelang Baru')

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-hammer-line mr-2"></i>
                Form Buka Lelang
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('auctions.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="item_id" class="form-label">Pilih Barang</label>
                    <select name="item_id" id="item_id" class="form-input" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}" 
                                {{ (old('item_id') ?? request('item_id')) == $item->id ? 'selected' : '' }}
                                data-price="{{ $item->starting_price }}"
                                data-increment="{{ $item->minimum_bid_increment }}">
                            {{ $item->name }} - Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                            ({{ $item->user->name ?? '-' }})
                        </option>
                        @endforeach
                    </select>
                    @error('item_id')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Item Preview -->
                <div id="itemPreview" class="mb-6 p-4 bg-medieval-parchment/30 rounded-lg hidden">
                    <h4 class="font-semibold text-medieval-brown mb-3">Preview Barang</h4>
                    <div id="itemDetails"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="start_time" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" id="start_time" 
                               value="{{ old('start_time', now()->format('Y-m-d\TH:i')) }}" 
                               class="form-input" required>
                        @error('start_time')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="duration_days" class="form-label">Durasi Lelang (Hari)</label>
                        <input type="number" name="duration_days" id="duration_days" 
                               value="{{ old('duration_days', 7) }}" 
                               min="1" max="30" class="form-input" required>
                        @error('duration_days')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="ri-information-line text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-800">
                                Lelang akan berakhir pada: <strong id="endTimePreview">-</strong>
                            </p>
                            <p class="text-xs text-blue-600 mt-1">
                                Harga awal dan kenaikan minimum akan diambil dari data barang.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-play-line mr-2"></i>
                        Buka Lelang
                    </button>
                    <a href="{{ route('auctions.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('start_time').addEventListener('change', updateEndTime);
    document.getElementById('duration_days').addEventListener('change', updateEndTime);
    
    function updateEndTime() {
        const startTime = new Date(document.getElementById('start_time').value);
        const days = parseInt(document.getElementById('duration_days').value);
        
        if (startTime && days) {
            const endTime = new Date(startTime.getTime() + (days * 24 * 60 * 60 * 1000));
            document.getElementById('endTimePreview').textContent = endTime.toLocaleString('id-ID');
        }
    }
    
    updateEndTime();
</script>
@endpush
@endsection

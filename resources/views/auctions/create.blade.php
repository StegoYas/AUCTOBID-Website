@extends('layouts.app')

@section('title', 'Buka Lelang')
@section('page-title', 'Dekrit Lelang Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <x-medieval-card title="Formulir Pembukaan Lelang" icon="ri-auction-line">
        <form action="{{ route('auctions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column: Item Selection -->
                <div class="space-y-6">
                    <div>
                        <label for="item_id" class="block text-sm font-cinzel font-bold text-medieval-brown mb-2">
                            <i class="ri-archive-line mr-1"></i> Pilih Harta / Barang
                            <span class="text-medieval-crimson">*</span>
                        </label>
                        <select name="item_id" id="item_id" 
                                class="w-full px-4 py-3 bg-white/80 border-2 border-medieval-gold/50 rounded-lg text-medieval-slate font-merriweather focus:border-medieval-gold focus:ring-2 focus:ring-medieval-gold/20 shadow-inner-parchment" 
                                required>
                            <option value="">-- Pilih Barang dari Gudang --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                    {{ (old('item_id') ?? request('item_id')) == $item->id ? 'selected' : '' }}
                                    data-price="{{ $item->starting_price }}"
                                    data-increment="{{ $item->minimum_bid_increment }}">
                                {{ $item->name }} ({{ $item->user->name ?? 'Anonim' }})
                            </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <p class="mt-1 text-sm text-medieval-crimson font-bold flex items-center"><i class="ri-error-warning-line mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Item Preview Box -->
                    <div id="itemPreview" class="hidden p-6 bg-medieval-parchment border-2 border-medieval-brown/20 rounded-lg relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-medieval-gold/10 rounded-bl-full z-0"></div>
                        <h4 class="font-cinzel font-bold text-medieval-brown mb-4 border-b border-medieval-brown/10 pb-2 relative z-10 flex items-center">
                            <i class="ri-eye-line mr-2"></i> Detail Barang
                        </h4>
                        <div class="space-y-2 relative z-10">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-medieval-slate/70 font-merriweather italic">Harga Awal:</span>
                                <span class="font-bold text-medieval-brown font-cinzel text-lg" id="previewPrice">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-medieval-slate/70 font-merriweather italic">Min. Kenaikan:</span>
                                <span class="font-bold text-medieval-gold font-cinzel text-md" id="previewIncrement">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Time Selection -->
                <div class="space-y-6">
                    <x-medieval-input 
                        type="datetime-local" 
                        name="start_time" 
                        label="Waktu Mulai Lelang" 
                        value="{{ old('start_time', now()->format('Y-m-d\TH:i')) }}" 
                        required 
                    />
                    
                    <div>
                        <label for="duration_days" class="block text-sm font-cinzel font-bold text-medieval-brown mb-2">
                            <i class="ri-hourglass-line mr-1"></i> Durasi Lelang (Hari)
                            <span class="text-medieval-crimson">*</span>
                        </label>
                        <div class="flex items-center space-x-4">
                            <input type="number" name="duration_days" id="duration_days" 
                                   value="{{ old('duration_days', 7) }}" 
                                   min="1" max="30" 
                                   class="flex-1 px-4 py-3 bg-white/80 border-2 border-medieval-gold/50 rounded-lg text-medieval-slate font-bold text-center focus:border-medieval-gold focus:ring-2 focus:ring-medieval-gold/20 shadow-inner-parchment" 
                                   required>
                            <span class="font-cinzel text-medieval-slate font-bold">Hari</span>
                        </div>
                        @error('duration_days')
                        <p class="mt-1 text-sm text-medieval-crimson font-bold"><i class="ri-error-warning-line mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time Info -->
                    <div class="p-4 bg-medieval-royal/5 rounded-lg border border-medieval-royal/20 flex items-start">
                        <i class="ri-calendar-check-line text-medieval-royal mt-1 mr-3 text-lg"></i>
                        <div>
                            <p class="text-sm font-bold text-medieval-royal font-cinzel">Estimasi Selesai:</p>
                            <p class="text-lg font-bold text-medieval-slate mt-1" id="endTimePreview">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-medieval-gold/20 mt-8">
                <a href="{{ route('auctions.index') }}" class="px-6 py-2.5 rounded-lg border-2 border-medieval-brown text-medieval-brown font-cinzel font-bold hover:bg-medieval-brown hover:text-white transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-b from-medieval-brown to-medieval-dark-brown text-medieval-gold font-cinzel font-bold border-2 border-medieval-gold shadow-medieval hover:shadow-gold hover:-translate-y-1 transition-all flex items-center">
                    <i class="ri-hammer-fill mr-2"></i>
                    Resmikan Lelang
                </button>
            </div>
        </form>
    </x-medieval-card>
</div>

@push('scripts')
<script>
    const itemSelect = document.getElementById('item_id');
    const itemPreview = document.getElementById('itemPreview');
    const previewPrice = document.getElementById('previewPrice');
    const previewIncrement = document.getElementById('previewIncrement');
    
    // Format Currency Helper
    const formatCurrenty = (num) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    };

    itemSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            itemPreview.classList.remove('hidden');
            previewPrice.textContent = formatCurrenty(selected.dataset.price);
            previewIncrement.textContent = formatCurrenty(selected.dataset.increment);
        } else {
            itemPreview.classList.add('hidden');
        }
    });

    // Time Calculation
    document.getElementById('start_time').addEventListener('change', updateEndTime);
    document.getElementById('duration_days').addEventListener('input', updateEndTime);
    
    function updateEndTime() {
        const startTimeInput = document.getElementById('start_time').value;
        const daysInput = document.getElementById('duration_days').value;
        
        if (startTimeInput && daysInput) {
            const startTime = new Date(startTimeInput);
            const days = parseInt(daysInput);
            const endTime = new Date(startTime.getTime() + (days * 24 * 60 * 60 * 1000));
            
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('endTimePreview').textContent = endTime.toLocaleDateString('id-ID', options);
        }
    }
    
    // Init
    updateEndTime();
    if(itemSelect.value) itemSelect.dispatchEvent(new Event('change'));
</script>
@endpush
@endsection

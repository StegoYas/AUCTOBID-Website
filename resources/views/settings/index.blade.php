@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem Kerajaan')

@section('content')
<div class="max-w-4xl mx-auto relative group">
    <!-- Decorative primitive scroll ends (visual only) -->
    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-[110%] h-12 bg-[#8B4513] rounded-full shadow-lg z-0 border-2 border-[#D4AF37]"></div>
    <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 w-[110%] h-12 bg-[#8B4513] rounded-full shadow-lg z-0 border-2 border-[#D4AF37]"></div>

    <div class="relative z-10 bg-[#FFF8DC] p-8 md:p-12 shadow-[0_0_50px_rgba(0,0,0,0.3)] border-x-8 border-[#D4AF37]/50 bg-parchment-texture rounded-lg">
        <!-- Header -->
        <div class="text-center mb-10 pb-6 border-b-2 border-[#D4AF37] relative">
            <i class="ri-settings-3-fill text-5xl text-[#D4AF37] mb-4 drop-shadow-md inline-block"></i>
            <h2 class="font-cinzel text-3xl font-bold text-[#5D2E0C]">Dekrit Pengaturan</h2>
            <p class="font-merriweather italic text-[#5D2E0C]/70 mt-2">Konfigurasi Hukum & Tata Tertib Kerajaan</p>
            
            <!-- Wax Seal Decoration -->
            <div class="absolute -right-4 -top-4 opacity-80 rotate-12">
                <img src="{{ asset('images/wax-seal-red.png') }}" alt="Seal" class="w-24 h-24 drop-shadow-lg opacity-80 hover:opacity-100 transition-opacity duration-500">
            </div>
        </div>
        
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Commission -->
                <div class="p-6 border-2 border-[#D4AF37]/30 rounded-lg bg-[#D4AF37]/5 hover:bg-[#D4AF37]/10 transition-colors group/input">
                    <label for="commission_percentage" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-percent-line mr-2"></i>Upeti Kerajaan (%)
                    </label>
                    <input type="number" name="commission_percentage" id="commission_percentage" 
                           value="{{ old('commission_percentage', $settings['commission_percentage']->value ?? 5) }}" 
                           step="0.1" min="0" max="50"
                           class="w-full bg-white/50 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all shadow-inner-parchment">
                    <p class="text-xs text-[#5D2E0C]/60 mt-2 italic">Potongan wajib untuk kas negara.</p>
                </div>
                
                <!-- Duration -->
                <div class="p-6 border-2 border-[#D4AF37]/30 rounded-lg bg-[#D4AF37]/5 hover:bg-[#D4AF37]/10 transition-colors group/input">
                    <label for="default_auction_duration" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-hourglass-2-fill mr-2"></i>Masa Berlaku Lelang (Hari)
                    </label>
                    <input type="number" name="default_auction_duration" id="default_auction_duration" 
                           value="{{ old('default_auction_duration', $settings['default_auction_duration']->value ?? 7) }}" 
                           min="1" max="30"
                           class="w-full bg-white/50 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all shadow-inner-parchment">
                    <p class="text-xs text-[#5D2E0C]/60 mt-2 italic">Durasi standar maklumat lelang.</p>
                </div>
                
                <!-- Bid Increment -->
                <div class="p-6 border-2 border-[#D4AF37]/30 rounded-lg bg-[#D4AF37]/5 hover:bg-[#D4AF37]/10 transition-colors group/input">
                    <label for="minimum_bid_increment" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-coins-line mr-2"></i>Kenaikan Penawaran Min. (Wps)
                    </label>
                    <input type="number" name="minimum_bid_increment" id="minimum_bid_increment" 
                           value="{{ old('minimum_bid_increment', $settings['minimum_bid_increment']->value ?? 10000) }}" 
                           min="1000"
                           class="w-full bg-white/50 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all shadow-inner-parchment">
                    <p class="text-xs text-[#5D2E0C]/60 mt-2 italic">Syarat minimum kenaikan harga.</p>
                </div>
                
                <!-- Max Images -->
                <div class="p-6 border-2 border-[#D4AF37]/30 rounded-lg bg-[#D4AF37]/5 hover:bg-[#D4AF37]/10 transition-colors group/input">
                    <label for="max_item_images" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-image-edit-line mr-2"></i>Batas Lukisan Barang
                    </label>
                    <input type="number" name="max_item_images" id="max_item_images" 
                           value="{{ old('max_item_images', $settings['max_item_images']->value ?? 5) }}" 
                           min="1" max="10"
                           class="w-full bg-white/50 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all shadow-inner-parchment">
                    <p class="text-xs text-[#5D2E0C]/60 mt-2 italic">Maksimal lukisan per artefak.</p>
                </div>
            </div>
            
            <div class="mt-10 pt-8 border-t-2 border-[#D4AF37]/30 flex justify-center">
                <button type="submit" class="group relative px-8 py-3 bg-[#8B4513] text-[#D4AF37] font-cinzel font-bold tracking-wider rounded border-2 border-[#D4AF37] shadow-[0_4px_0_#5D2E0C] hover:shadow-[0_2px_0_#5D2E0C] hover:translate-y-[2px] active:shadow-none active:translate-y-[4px] transition-all">
                    <span class="flex items-center">
                        <i class="ri-quill-pen-fill mr-2 group-hover:rotate-12 transition-transform"></i>
                        SAHKAN PERUBAHAN
                    </span>
                    <!-- Button Glow -->
                    <div class="absolute inset-0 rounded bg-[#D4AF37] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

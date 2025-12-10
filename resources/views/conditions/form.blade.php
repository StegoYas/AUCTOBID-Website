@extends('layouts.app')

@section('title', isset($condition) ? 'Edit Kondisi' : 'Tambah Kondisi')
@section('page-title', isset($condition) ? 'Ubah Maklumat Kondisi' : 'Buat Maklumat Kondisi Baru')

@section('content')
<div class="max-w-3xl mx-auto relative group">
    <!-- Decorative primitive scroll ends (visual only) -->
    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 w-[105%] h-10 bg-[#8B4513] rounded-full shadow-lg z-0 border border-[#D4AF37]"></div>
    <div class="absolute -bottom-5 left-1/2 transform -translate-x-1/2 w-[105%] h-10 bg-[#8B4513] rounded-full shadow-lg z-0 border border-[#D4AF37]"></div>

    <div class="relative z-10 bg-[#FFF8DC] border-x-4 border-[#D4AF37] p-8 md:p-10 shadow-2xl bg-parchment-texture rounded-sm">
        <!-- Header -->
        <div class="text-center mb-8 pb-4 border-b-2 border-[#D4AF37]/30 relative">
            <h2 class="font-cinzel text-2xl font-bold text-[#5D2E0C]">
                @if(isset($condition))
                    <i class="ri-edit-circle-fill text-[#D4AF37] mr-2"></i>Perbarui Standar Kualitas
                @else
                    <i class="ri-add-circle-fill text-[#D4AF37] mr-2"></i>Tetapkan Standar Baru
                @endif
            </h2>
            
            <!-- Wax Seal -->
             <div class="absolute right-0 top-0 opacity-80">
                <img src="{{ asset('images/wax-seal-red.png') }}" alt="Seal" class="w-16 h-16 drop-shadow-md">
            </div>
        </div>
        
        <form action="{{ isset($condition) ? route('conditions.update', $condition) : route('conditions.store') }}" method="POST">
            @csrf
            @if(isset($condition))
                @method('PUT')
            @endif
            
            <div class="space-y-6">
                <!-- Name Field -->
                <div class="group/input">
                    <label for="name" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-t-shirt-line mr-2"></i>Nama Kondisi
                    </label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $condition->name ?? '') }}" 
                           class="w-full bg-white/40 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] placeholder-[#5D2E0C]/30 focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all"
                           placeholder="Contoh: Baru, Bekas Layak Pakai...">
                    @error('name')
                    <p class="text-red-600 text-xs mt-1 font-merriweather italic flex items-center"><i class="ri-error-warning-line mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description Field -->
                <div class="group/input">
                    <label for="description" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-file-text-line mr-2"></i>Detail Kriteria
                    </label>
                    <textarea name="description" id="description" rows="4" 
                              class="w-full bg-white/40 border-2 border-[#D4AF37]/50 rounded px-4 py-2 font-merriweather text-[#5D2E0C] placeholder-[#5D2E0C]/30 focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:outline-none transition-all">{{ old('description', $condition->description ?? '') }}</textarea>
                    @error('description')
                    <p class="text-red-600 text-xs mt-1 font-merriweather italic flex items-center"><i class="ri-error-warning-line mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Rating Field -->
                <div class="group/input">
                    <label for="quality_rating" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 group-hover/input:text-[#D4AF37] transition-colors">
                        <i class="ri-star-line mr-2"></i>Tingkat Kualitas (1-10)
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="range" name="quality_rating" id="quality_rating" 
                               min="1" max="10" value="{{ old('quality_rating', $condition->quality_rating ?? 5) }}"
                               class="flex-1 accent-[#D4AF37] h-2 bg-[#D4AF37]/20 rounded-lg appearance-none cursor-pointer"
                               oninput="document.getElementById('rating-val').textContent = this.value">
                        <span id="rating-val" class="font-cinzel font-bold text-2xl text-[#8B4513] w-8 text-center">{{ old('quality_rating', $condition->quality_rating ?? 5) }}</span>
                    </div>
                     <p class="text-xs text-[#5D2E0C]/60 mt-1 italic">Geser untuk menentukan nilai kualitas barang.</p>
                    @error('quality_rating')
                    <p class="text-red-600 text-xs mt-1 font-merriweather italic flex items-center"><i class="ri-error-warning-line mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Is Active Toggle -->
                 <div class="group/input flex items-center justify-between p-4 bg-[#D4AF37]/10 rounded border border-[#D4AF37]/30">
                    <div class="flex items-center">
                         <div class="relative">
                            <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" {{ old('is_active', $condition->is_active ?? true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-400 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#D4AF37]"></div>
                        </div>
                        <label for="is_active" class="ml-3 font-cinzel font-bold text-[#5D2E0C] cursor-pointer selection:bg-none">Status Aktif</label>
                    </div>
                </div>

            </div>
            
            <div class="mt-10 pt-6 border-t border-[#D4AF37]/30 flex justify-end space-x-4">
                <a href="{{ route('conditions.index') }}" class="px-6 py-2 border-2 border-[#5D2E0C]/50 text-[#5D2E0C] font-bold font-cinzel rounded hover:bg-[#5D2E0C]/10 transition-colors">
                    BATALKAN
                </a>
                <button type="submit" class="group relative px-8 py-2 bg-[#8B4513] text-[#D4AF37] font-cinzel font-bold tracking-wider rounded border-2 border-[#D4AF37] shadow-[0_4px_0_#5D2E0C] hover:shadow-[0_2px_0_#5D2E0C] hover:translate-y-[2px] active:shadow-none active:translate-y-[4px] transition-all">
                    <span class="flex items-center relative z-10">
                        <i class="ri-save-3-fill mr-2"></i>
                        {{ isset($condition) ? 'PERBARUI' : 'SIMPAN' }}
                    </span>
                    <div class="absolute inset-0 bg-[#D4AF37] opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

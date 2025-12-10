@extends('layouts.app')

@section('title', 'Ajukan Barang Pusaka')
@section('page-title', 'Ajukan Barang')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-cinzel font-bold text-medieval-brown flex items-center justify-center">
            <i class="ri-upload-cloud-line mr-3"></i> Form Pengajuan Harta
        </h2>
        <p class="text-medieval-slate mt-2 font-merriweather italic">
            Isimulir rincian barang yang hendak Anda lelangkan di hadapan rakyat.
        </p>
    </div>

    <x-medieval-card class="relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 p-10 opacity-5 pointer-events-none">
            <i class="ri-sword-line text-9xl"></i>
        </div>

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <x-medieval-input 
                        name="name" 
                        label="Nama Barang" 
                        placeholder="cth. Pedang Excalibur" 
                        required 
                        :value="old('name')" 
                    />
                    
                    <div>
                        <label class="block font-cinzel text-sm font-bold text-medieval-brown mb-2">Kategori</label>
                        <select name="category_id" class="w-full rounded-md border-medieval-gold/50 bg-medieval-paper font-merriweather focus:border-medieval-gold focus:ring focus:ring-medieval-gold/50">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <x-medieval-input 
                        name="starting_price" 
                        label="Harga Awal (Rp)" 
                        type="number" 
                        placeholder="0" 
                        required 
                        :value="old('starting_price')" 
                    />
                    
                    <div>
                        <label class="block font-cinzel text-sm font-bold text-medieval-brown mb-2">Kondisi Barang</label>
                        <div class="flex space-x-4">
                            @foreach(\App\Models\Condition::all() as $condition)
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="radio" name="condition_id" value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'checked' : '' }} class="text-medieval-brown focus:ring-medieval-gold border-medieval-gold">
                                    <span class="font-merriweather text-medieval-slate group-hover:text-medieval-brown transition">{{ $condition->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('condition_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Full Width Inputs -->
            <div>
                <label class="block font-cinzel text-sm font-bold text-medieval-brown mb-2">Deskripsi Lengkap</label>
                <textarea name="description" rows="4" class="w-full rounded-md border-medieval-gold/50 bg-medieval-paper font-merriweather focus:border-medieval-gold focus:ring focus:ring-medieval-gold/50 placeholder-medieval-slate/40" placeholder="Ceritakan riwayat dan kondisi barang...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-6 border-2 border-dashed border-medieval-gold/30 rounded-lg bg-medieval-parchment/30 text-center hover:bg-medieval-gold/5 transition-colors cursor-pointer group">
                <i class="ri-image-add-line text-4xl text-medieval-gold mb-2 group-hover:scale-110 transition-transform block"></i>
                <label class="block font-cinzel text-sm font-bold text-medieval-brown mb-1 cursor-pointer">
                    Unggah Gambar Utama
                    <input type="file" name="image" class="hidden" accept="image/*">
                </label>
                <p class="text-xs text-medieval-slate/60">Format: JPG, PNG. Maks: 2MB</p>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-medieval-gold/20">
                <a href="{{ route('items.index') }}" class="px-6 py-2 rounded border border-medieval-brown text-medieval-brown font-cinzel font-bold hover:bg-medieval-brown hover:text-white transition-colors">
                    Batal
                </a>
                <x-medieval-button type="primary" class="px-8">
                    <i class="ri-quill-pen-line mr-2"></i> Ajukan Barang
                </x-medieval-button>
            </div>
        </form>
    </x-medieval-card>
</div>
@endsection

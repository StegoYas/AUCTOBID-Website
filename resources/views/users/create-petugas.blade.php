@extends('layouts.app')

@section('title', 'Tambah Petugas')
@section('page-title', 'Lantik Ksatria Baru')

@section('content')
<div class="max-w-4xl mx-auto relative group">
     <!-- Decorative Elements -->
    <div class="absolute -top-4 -left-4 w-16 h-16 border-t-4 border-l-4 border-[#D4AF37] rounded-tl-lg z-0"></div>
    <div class="absolute -top-4 -right-4 w-16 h-16 border-t-4 border-r-4 border-[#D4AF37] rounded-tr-lg z-0"></div>
    <div class="absolute -bottom-4 -left-4 w-16 h-16 border-b-4 border-l-4 border-[#D4AF37] rounded-bl-lg z-0"></div>
    <div class="absolute -bottom-4 -right-4 w-16 h-16 border-b-4 border-r-4 border-[#D4AF37] rounded-br-lg z-0"></div>

    <div class="relative z-10 bg-[#FFF8DC] border border-[#D4AF37] shadow-2xl rounded-lg overflow-hidden bg-parchment-texture">
        <!-- Header -->
        <div class="bg-[#2C1810] p-6 border-b-2 border-[#D4AF37] relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern-knight.png')] opacity-10"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="font-cinzel text-2xl font-bold text-[#D4AF37] flex items-center">
                        <i class="ri-sword-fill mr-3 text-3xl"></i>
                        Lantik Petugas Kerajaan
                    </h2>
                    <p class="font-merriweather italic text-[#D4AF37]/70 mt-1 ml-10">Menambah jajaran penjaga & pengelola sistem.</p>
                </div>
                <!-- Shield Icon Decor -->
                <i class="ri-shield-user-fill text-6xl text-[#D4AF37]/20 absolute right-6 top-1/2 transform -translate-y-1/2"></i>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('users.store-petugas') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column: Identity -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4 pb-2 border-b border-[#D4AF37]/30">
                            <span class="w-8 h-8 rounded-full bg-[#D4AF37] flex items-center justify-center text-[#2C1810] font-bold font-cinzel">I</span>
                            <h3 class="font-cinzel font-bold text-[#5D2E0C]">Identitas Ksatria</h3>
                        </div>

                        <div class="group/input">
                            <label for="name" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 text-sm">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]"><i class="ri-user-3-fill"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                       class="w-full bg-white/50 border border-[#D4AF37] rounded pl-10 pr-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none transition-shadow" placeholder="Nama Petugas">
                            </div>
                            @error('name')<p class="text-red-600 text-xs mt-1 italic">{{ $message }}</p>@enderror
                        </div>

                        <div class="group/input">
                            <label for="email" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 text-sm">Surat Elektronik (Email)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]"><i class="ri-mail-fill"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                       class="w-full bg-white/50 border border-[#D4AF37] rounded pl-10 pr-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none transition-shadow" placeholder="petugas@kerajaan.id">
                            </div>
                            @error('email')<p class="text-red-600 text-xs mt-1 italic">{{ $message }}</p>@enderror
                        </div>

                        <div class="group/input">
                            <label for="phone" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 text-sm">Nomor Kontak</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]"><i class="ri-phone-fill"></i></span>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                                       class="w-full bg-white/50 border border-[#D4AF37] rounded pl-10 pr-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none transition-shadow" placeholder="08...">
                            </div>
                            @error('phone')<p class="text-red-600 text-xs mt-1 italic">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Right Column: Secrets -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2 mb-4 pb-2 border-b border-[#D4AF37]/30">
                            <span class="w-8 h-8 rounded-full bg-[#D4AF37] flex items-center justify-center text-[#2C1810] font-bold font-cinzel">II</span>
                            <h3 class="font-cinzel font-bold text-[#5D2E0C]">Kunci & Sandi</h3>
                        </div>

                        <div class="group/input">
                            <label for="password" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 text-sm">Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]"><i class="ri-lock-fill"></i></span>
                                <input type="password" name="password" id="password" 
                                       class="w-full bg-white/50 border border-[#D4AF37] rounded pl-10 pr-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none transition-shadow">
                            </div>
                            @error('password')<p class="text-red-600 text-xs mt-1 italic">{{ $message }}</p>@enderror
                        </div>

                        <div class="group/input">
                            <label for="password_confirmation" class="block font-cinzel font-bold text-[#5D2E0C] mb-2 text-sm">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37]"><i class="ri-lock-check-fill"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="w-full bg-white/50 border border-[#D4AF37] rounded pl-10 pr-4 py-2 font-merriweather text-[#5D2E0C] focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none transition-shadow">
                            </div>
                        </div>

                        <div class="p-4 bg-[#D4AF37]/10 rounded border border-[#D4AF37]/20 mt-6">
                            <h4 class="font-cinzel font-bold text-[#5D2E0C] text-xs mb-2"><i class="ri-information-fill mr-1"></i>Catatan:</h4>
                            <p class="text-xs text-[#5D2E0C]/70 italic">
                                Petugas akan memiliki akses untuk mengelola lelang dan barang. Pastikan data yang dimasukkan benar dan dapat dipertanggungjawabkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-[#D4AF37]/30 flex justify-end space-x-4">
                    <a href="{{ route('users.index') }}" class="px-6 py-2 text-[#5D2E0C] font-bold font-cinzel hover:underline">
                        KEMBALI KE DAFTAR
                    </a>
                    <button type="submit" class="px-8 py-3 bg-[#2C1810] text-[#D4AF37] font-cinzel font-bold tracking-wider rounded shadow-lg border border-[#D4AF37] hover:bg-[#3E2218] transition-colors flex items-center">
                        <i class="ri-check-double-line mr-2"></i>
                        LANTIK PETUGAS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

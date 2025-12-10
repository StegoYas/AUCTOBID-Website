@extends('layouts.guest')

@section('title', 'Pendaftaran Penduduk')

@section('content')
<div class="text-center mb-8">
    <div class="inline-block p-4 rounded-full bg-medieval-gold/10 border-2 border-medieval-gold mb-4 shadow-gold">
        <i class="ri-quill-pen-line text-4xl text-medieval-brown"></i>
    </div>
    <h1 class="text-3xl font-cinzel font-bold text-medieval-brown drop-shadow-sm">Permohonan Warga</h1>
    <p class="mt-2 text-medieval-slate font-merriweather italic">Bergabunglah dengan Kerajaan Auctobid</p>
</div>

<x-medieval-card class="max-w-md mx-auto transform hover:scale-[1.01] transition-transform duration-300">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-medieval-input 
                id="name" 
                name="name" 
                label="Nama Lengkap" 
                type="text" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="cth. Sir Lancelot"
            />
        </div>

        <!-- Email -->
        <div>
            <x-medieval-input 
                id="email" 
                name="email" 
                label="Surat Elektronik (Email)" 
                type="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="surat@kerajaan.com"
            />
        </div>

        <!-- Password -->
        <div>
            <x-medieval-input 
                id="password" 
                name="password" 
                label="Kata Sandi Rahasia" 
                type="password" 
                required 
                autocomplete="new-password"
            />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-medieval-input 
                id="password_confirmation" 
                name="password_confirmation" 
                label="Konfirmasi Kata Sandi" 
                type="password" 
                required 
                autocomplete="new-password"
            />
        </div>

        <div class="flex items-center justify-between mt-6 pt-4 border-t border-medieval-gold/20">
            <a class="text-sm text-medieval-brown hover:text-medieval-gold underline decoration-medieval-gold/50 font-merriweather transition-colors" href="{{ route('login') }}">
                {{ __('Sudah terdaftar?') }}
            </a>

            <x-medieval-button type="primary" class="ml-4 shadow-lg group">
                <span class="group-hover:translate-x-1 transition-transform inline-block">Ajukan Diri</span>
                <i class="ri-arrow-right-line ml-2 group-hover:translate-x-1 transition-transform"></i>
            </x-medieval-button>
        </div>
    </form>
</x-medieval-card>

<div class="mt-8 text-center">
    <p class="text-xs text-medieval-slate/60 font-cinzel">
        &copy; {{ date('Y') }} Kerajaan Auctobid. Dilindungi oleh Titah Raja.
    </p>
</div>
@endsection

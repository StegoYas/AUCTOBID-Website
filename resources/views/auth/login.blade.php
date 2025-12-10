@extends('layouts.guest')

@section('title', 'Gerbang Masuk')

@section('content')
<x-medieval-card class="shadow-2xl">
    <div class="text-center mb-8">
        <div class="w-24 h-24 mx-auto mb-4 bg-medieval-gold/20 rounded-full flex items-center justify-center border-2 border-medieval-gold shadow-gold">
            <img src="{{ asset('images/AUCTOBID-Favicon.png') }}" alt="AUCTOBID" class="h-16 w-auto drop-shadow-md">
        </div>
        <h1 class="text-3xl font-cinzel font-bold text-medieval-brown mb-2 tracking-wider">AUCTOBID</h1>
        <p class="text-sm font-uncial text-medieval-slate uppercase tracking-widest border-t border-b border-medieval-gold/30 inline-block py-1">
            Gerbang Administrasi Kerajaan
        </p>
    </div>
    
    <div class="space-y-6">
        @if($errors->any())
        <div class="alert alert-error text-sm">
            @foreach($errors->all() as $error)
                <p class="flex items-center"><i class="ri-error-warning-fill mr-2"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <x-medieval-input 
                label="Surat Elektronik (Email)" 
                name="email" 
                type="email" 
                icon="ri-mail-quill-line"
                placeholder="masukkan@email.kerajaan" 
                required 
                autofocus
            />
            
            <div class="relative">
                <x-medieval-input 
                    label="Kunci Sandi (Password)" 
                    name="password" 
                    type="password" 
                    icon="ri-key-2-line"
                    placeholder="••••••••" 
                    required
                />
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded border-medieval-gold text-medieval-brown focus:ring-medieval-gold cursor-pointer">
                    <span class="ml-2 text-sm text-medieval-slate group-hover:text-medieval-brown transition-colors">Ingat Saya</span>
                </label>
                <!-- Optional: Forgot Password Link -->
                <!-- <a href="#" class="text-sm text-medieval-brown hover:text-medieval-gold underline decoration-medieval-gold/50">Lupa Sandi?</a> -->
            </div>
            
            <x-medieval-button type="primary" class="w-full text-lg group-hover:shadow-gold" icon="ri-door-open-line">
                Masuki Gerbang
            </x-medieval-button>
        </form>
    </div>
    
    <div class="mt-8 text-center border-t border-medieval-gold/20 pt-4">
        <p class="text-xs text-medieval-slate/50 font-merriweather italic">
            &copy; {{ date('Y') }} AUCTOBID. Dilindungi oleh Titah Raja.
        </p>
    </div>
</x-medieval-card>
@endsection

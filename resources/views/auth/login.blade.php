@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <img src="{{ asset('images/AUCTOBID-Logo.png') }}" alt="AUCTOBID" class="h-20 mx-auto mb-4">
        <h1 class="text-2xl font-cinzel font-bold text-medieval-brown">AUCTOBID</h1>
        <p class="text-sm text-medieval-slate/70 mt-1">Sistem Lelang Online</p>
    </div>
    
    <div class="card-body">
        <h2 class="text-xl font-cinzel font-semibold text-center text-medieval-brown mb-6">Login Admin Panel</h2>
        
        @if($errors->any())
        <div class="alert alert-error mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    class="form-input" 
                    placeholder="Masukkan email"
                    required 
                    autofocus
                >
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-input" 
                    placeholder="Masukkan password"
                    required
                >
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-medieval-gold/30 text-medieval-brown focus:ring-medieval-gold">
                    <span class="ml-2 text-sm text-medieval-slate">Ingat saya</span>
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk
            </button>
        </form>
    </div>
    
    <div class="card-footer text-center">
        <p class="text-sm text-medieval-slate/60">
            &copy; {{ date('Y') }} AUCTOBID. All rights reserved.
        </p>
    </div>
</div>
@endsection

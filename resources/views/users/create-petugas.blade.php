@extends('layouts.app')

@section('title', 'Tambah Petugas')
@section('page-title', 'Tambah Petugas Baru')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-user-add-line mr-2"></i>
                Form Tambah Petugas
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('users.store-petugas') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="form-input" required>
                    @error('name')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="form-input" required>
                    @error('email')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="form-input">
                    @error('phone')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" 
                           class="form-input" required>
                    @error('password')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-input" required>
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line mr-2"></i>
                        Simpan Petugas
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

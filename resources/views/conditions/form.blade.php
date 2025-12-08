@extends('layouts.app')

@section('title', $condition ? 'Edit Kondisi' : 'Tambah Kondisi')
@section('page-title', $condition ? 'Edit Kondisi' : 'Tambah Kondisi')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-shield-check-line mr-2"></i>
                {{ $condition ? 'Edit Kondisi' : 'Tambah Kondisi Baru' }}
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ $condition ? route('conditions.update', $condition) : route('conditions.store') }}" method="POST">
                @csrf
                @if($condition)
                @method('PUT')
                @endif
                
                <div class="mb-4">
                    <label for="name" class="form-label">Nama Kondisi</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $condition->name ?? '') }}" 
                           class="form-input" required>
                    @error('name')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-input">{{ old('description', $condition->description ?? '') }}</textarea>
                    @error('description')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="quality_rating" class="form-label">Rating Kualitas (1-10)</label>
                    <input type="range" name="quality_rating" id="quality_rating" 
                           value="{{ old('quality_rating', $condition->quality_rating ?? 5) }}" 
                           min="1" max="10" class="w-full"
                           oninput="document.getElementById('rating_value').textContent = this.value">
                    <div class="flex justify-between text-sm text-medieval-slate/60 mt-1">
                        <span>1 (Buruk)</span>
                        <span id="rating_value">{{ old('quality_rating', $condition->quality_rating ?? 5) }}</span>
                        <span>10 (Sempurna)</span>
                    </div>
                    @error('quality_rating')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line mr-2"></i>
                        {{ $condition ? 'Simpan Perubahan' : 'Tambah Kondisi' }}
                    </button>
                    <a href="{{ route('conditions.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

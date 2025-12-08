@extends('layouts.app')

@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', $category ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-folder-line mr-2"></i>
                {{ $category ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ $category ? route('categories.update', $category) : route('categories.store') }}" method="POST">
                @csrf
                @if($category)
                @method('PUT')
                @endif
                
                <div class="mb-4">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $category->name ?? '') }}" 
                           class="form-input" required>
                    @error('name')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-input">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="icon" class="form-label">Icon (opsional)</label>
                    <input type="text" name="icon" id="icon" 
                           value="{{ old('icon', $category->icon ?? '') }}" 
                           class="form-input" placeholder="Contoh: ri-shopping-bag-line">
                    <p class="text-xs text-medieval-slate/60 mt-1">Gunakan nama icon dari Remix Icon</p>
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line mr-2"></i>
                        {{ $category ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

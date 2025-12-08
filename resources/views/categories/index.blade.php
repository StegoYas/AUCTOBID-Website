@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-folder-line mr-2"></i>
            Daftar Kategori
        </h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="ri-add-line mr-2"></i>
            Tambah Kategori
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Item</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="font-medium">{{ $category->name }}</td>
                    <td>{{ Str::limit($category->description, 50) ?? '-' }}</td>
                    <td>{{ $category->items_count }}</td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-approved' : 'badge-suspended' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline btn-sm">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('categories.toggle', $category) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn {{ $category->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                    <i class="ri-{{ $category->is_active ? 'close' : 'check' }}-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-medieval-slate/60">
                        Tidak ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection

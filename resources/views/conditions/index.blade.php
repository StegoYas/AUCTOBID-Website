@extends('layouts.app')

@section('title', 'Kondisi')
@section('page-title', 'Kelola Kondisi Barang')

@section('content')
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-shield-check-line mr-2"></i>
            Daftar Kondisi
        </h3>
        <a href="{{ route('conditions.create') }}" class="btn btn-primary btn-sm">
            <i class="ri-add-line mr-2"></i>
            Tambah Kondisi
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Rating Kualitas</th>
                    <th>Jumlah Item</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conditions as $condition)
                <tr>
                    <td class="font-medium">{{ $condition->name }}</td>
                    <td>{{ Str::limit($condition->description, 50) ?? '-' }}</td>
                    <td>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 10; $i++)
                                <i class="ri-star-{{ $i <= $condition->quality_rating ? 'fill' : 'line' }} text-medieval-gold text-xs"></i>
                            @endfor
                            <span class="ml-2">({{ $condition->quality_rating }}/10)</span>
                        </div>
                    </td>
                    <td>{{ $condition->items_count }}</td>
                    <td>
                        <span class="badge {{ $condition->is_active ? 'badge-approved' : 'badge-suspended' }}">
                            {{ $condition->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('conditions.edit', $condition) }}" class="btn btn-outline btn-sm">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('conditions.toggle', $condition) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn {{ $condition->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                    <i class="ri-{{ $condition->is_active ? 'close' : 'check' }}-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-medieval-slate/60">
                        Tidak ada kondisi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($conditions->hasPages())
    <div class="card-footer">
        {{ $conditions->links() }}
    </div>
    @endif
</div>
@endsection

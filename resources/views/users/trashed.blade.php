@extends('layouts.app')

@section('title', 'Sampah User')
@section('page-title', 'User Dihapus')

@section('content')
<div class="card">
    <div class="card-header flex justify-between items-center">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-delete-bin-line mr-2"></i>
            Daftar User Dihapus
        </h3>
        <div class="flex space-x-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline">
                <i class="ri-arrow-left-line mr-1"></i>
                Kembali
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Search -->
        <div class="mb-4">
            <form action="{{ route('users.trashed') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-input pl-10" placeholder="Cari nama atau email...">
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status Terakhir</th>
                        <th>Dihapus Pada</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2 overflow-hidden">
                                    @if($user->profile_photo)
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="ri-user-line text-gray-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-primary' : ($user->role === 'petugas' ? 'badge-secondary' : 'badge-outline') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-gray">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->deleted_at->format('d M Y H:i') }}</td>
                        <td class="text-right">
                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Pulihkan user ini?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success text-white" title="Pulihkan">
                                    <i class="ri-refresh-line"></i> Pulihkan
                                </button>
                            </form>
                            
                            <form action="{{ route('users.force-delete', $user->id) }}" method="POST" class="inline-block ml-1" onsubmit="return confirm('Hapus permanen? Data tidak bisa dikembalikan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            <i class="ri-delete-bin-line text-4xl mb-2 block"></i>
                            Tidak ada user yang dihapus.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

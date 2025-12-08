@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('page-title', 'Daftar Pengguna')

@section('content')
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-user-line mr-2"></i>
            Semua Pengguna
        </h3>
        <a href="{{ route('users.create-petugas') }}" class="btn btn-primary btn-sm">
            <i class="ri-user-add-line mr-2"></i>
            Tambah Petugas
        </a>
    </div>
    
    <div class="p-4 border-b border-medieval-gold/10">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama atau email..." 
                   class="form-input flex-1 min-w-[200px]">
            <select name="role" class="form-input w-40">
                <option value="all">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
            </select>
            <select name="status" class="form-input w-40">
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="ri-search-line"></i>
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-medieval-gold/20 flex items-center justify-center">
                                <i class="ri-user-line text-medieval-brown"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ $user->name }}</p>
                                <p class="text-xs text-medieval-slate/60">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="capitalize">{{ $user->role }}</span></td>
                    <td><span class="badge badge-{{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline btn-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                            @if($user->status == 'pending')
                            <form action="{{ route('users.approve', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="ri-check-line"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-medieval-slate/60">
                        Tidak ada data pengguna
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Pengguna Pending')
@section('page-title', 'Persetujuan Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="font-cinzel font-semibold text-medieval-brown">
            <i class="ri-user-add-line mr-2"></i>
            Pendaftaran Menunggu Persetujuan
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Tanggal Daftar</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
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
                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ Str::limit($user->address, 30) ?? '-' }}</td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline btn-sm">
                                <i class="ri-eye-line"></i>
                            </a>
                            <form action="{{ route('users.approve', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="ri-check-line"></i>
                                </button>
                            </form>
                            <form action="{{ route('users.reject', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menolak pendaftaran ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="ri-close-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-medieval-slate/60">
                        <i class="ri-checkbox-circle-line text-4xl text-green-500"></i>
                        <p class="mt-2">Tidak ada pendaftaran yang menunggu persetujuan</p>
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

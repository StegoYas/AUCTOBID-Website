@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="max-w-4xl">
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-user-line mr-2"></i>
                Informasi Pengguna
            </h3>
            <span class="badge badge-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
        </div>
        
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        @if($user->profile_photo)
                        <img src="{{ $user->profile_photo_url }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                        <div class="w-20 h-20 rounded-full bg-medieval-gold/20 flex items-center justify-center">
                            <i class="ri-user-line text-3xl text-medieval-brown"></i>
                        </div>
                        @endif
                        <div>
                            <h4 class="text-xl font-semibold">{{ $user->name }}</h4>
                            <p class="text-medieval-slate/60">{{ $user->email }}</p>
                            <span class="badge badge-{{ $user->role == 'admin' ? 'approved' : ($user->role == 'petugas' ? 'scheduled' : 'pending') }} mt-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="border-t border-medieval-gold/20 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-medieval-slate/60">Telepon</span>
                            <span>{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-medieval-slate/60">Alamat</span>
                            <span>{{ $user->address ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-medieval-slate/60">Tanggal Daftar</span>
                            <span>{{ $user->created_at->format('d M Y H:i') }}</span>
                        </div>
                        @if($user->approved_at)
                        <div class="flex justify-between">
                            <span class="text-medieval-slate/60">Tanggal Disetujui</span>
                            <span>{{ $user->approved_at->format('d M Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Identity Photo -->
                <div>
                    <h5 class="font-semibold mb-3">Foto Identitas</h5>
                    @if($user->identity_photo)
                    <img src="{{ $user->identity_photo_url }}" class="w-full rounded-lg border border-medieval-gold/20">
                    @else
                    <div class="w-full h-48 bg-medieval-parchment rounded-lg flex items-center justify-center">
                        <span class="text-medieval-slate/60">Belum ada foto identitas</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-footer flex flex-wrap gap-3">
            <a href="{{ route('users.index') }}" class="btn btn-outline">
                <i class="ri-arrow-left-line mr-2"></i> Kembali
            </a>
            
            @if($user->status == 'pending')
            <form action="{{ route('users.approve', $user) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="ri-check-line mr-2"></i> Setujui
                </button>
            </form>
            <form action="{{ route('users.reject', $user) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Yakin ingin menolak pengguna ini?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="ri-close-line mr-2"></i> Tolak
                </button>
            </form>
            @elseif($user->status == 'approved')
            <form action="{{ route('users.suspend', $user) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menangguhkan pengguna ini?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="ri-forbid-line mr-2"></i> Tangguhkan
                </button>
            </form>
            @elseif($user->status == 'suspended')
            <form action="{{ route('users.unsuspend', $user) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="ri-check-line mr-2"></i> Aktifkan Kembali
                </button>
            </form>
            @endif
            
            <form action="{{ route('users.reset-password', $user) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin reset password pengguna ini?')">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="ri-lock-password-line mr-2"></i> Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

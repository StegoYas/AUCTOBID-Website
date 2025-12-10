@extends('layouts.app')

@section('title', 'Detail Ksatria')
@section('page-title', 'Profil Warga')

@section('content')
<div class="max-w-4xl mx-auto">
    <x-medieval-card class="bg-medieval-paper">
        <x-slot name="actions">
            <span class="badge badge-{{ $user->status }} font-cinzel">{{ ucfirst($user->status) }}</span>
        </x-slot>

        <div class="card-header pb-6 border-b border-medieval-gold/30 flex items-center mb-6">
            <div class="bg-medieval-gold/10 p-3 rounded-full border border-medieval-gold/50 mr-4">
                <i class="ri-shield-user-line text-2xl text-medieval-brown"></i>
            </div>
            <div>
                <h3 class="font-cinzel font-bold text-xl text-medieval-brown">
                    Informasi Ksatria
                </h3>
                <p class="text-medieval-slate text-sm font-merriweather italic">Detail identitas warga kerajaan.</p>
            </div>
        </div>
        
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Profile Info -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-6">
                        <div class="relative">
                            @if($user->profile_photo)
                            <img src="{{ $user->profile_photo_url }}" class="w-24 h-24 rounded-full object-cover border-4 border-medieval-gold/30 shadow-lg">
                            @else
                            <div class="w-24 h-24 rounded-full bg-medieval-paper border-4 border-medieval-gold/30 flex items-center justify-center shadow-lg bg-medieval-pattern">
                                <i class="ri-user-line text-4xl text-medieval-brown/50"></i>
                            </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 bg-medieval-brown text-medieval-gold text-xs px-2 py-1 rounded-full border border-medieval-gold font-cinzel">
                                {{ ucfirst($user->role) }}
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <h4 class="text-2xl font-cinzel font-bold text-medieval-brown">{{ $user->name }}</h4>
                            <p class="text-medieval-slate font-merriweather">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 bg-medieval-parchment/50 p-4 rounded-lg border border-medieval-gold/10">
                        <div class="flex justify-between items-center border-b border-medieval-gold/10 pb-2">
                            <span class="text-medieval-slate/60 font-cinzel text-xs uppercase"><i class="ri-phone-line mr-2"></i>Telepon</span>
                            <span class="font-medium text-medieval-brown">{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-medieval-gold/10 pb-2">
                            <span class="text-medieval-slate/60 font-cinzel text-xs uppercase"><i class="ri-map-pin-line mr-2"></i>Alamat</span>
                            <span class="font-medium text-medieval-brown text-right max-w-[200px]">{{ $user->address ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-medieval-gold/10 pb-2">
                            <span class="text-medieval-slate/60 font-cinzel text-xs uppercase"><i class="ri-quill-pen-line mr-2"></i>Bergabung</span>
                            <span class="font-medium text-medieval-brown">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        @if($user->approved_at)
                        <div class="flex justify-between items-center">
                            <span class="text-medieval-slate/60 font-cinzel text-xs uppercase"><i class="ri-check-double-line mr-2"></i>Disetujui</span>
                            <span class="font-medium text-medieval-brown">{{ $user->approved_at->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Identity Photo -->
                <div class="space-y-3">
                    <h5 class="font-cinzel font-bold text-medieval-brown border-l-4 border-medieval-gold pl-3">Bukti Identitas</h5>
                    <div class="p-2 bg-medieval-paper rounded-lg border-2 border-dashed border-medieval-gold/30">
                        @if($user->identity_photo)
                        <img src="{{ $user->identity_photo_url }}" class="w-full h-48 object-cover rounded shadow-inner hover:scale-105 transition-transform duration-500 cursor-zoom-in">
                        @else
                        <div class="w-full h-48 bg-medieval-gold/5 rounded flex flex-col items-center justify-center text-medieval-slate/40">
                            <i class="ri-id-card-line text-4xl mb-2"></i>
                            <span class="font-cinzel text-sm">Tidak ada dokumen identitas</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-medieval-gold/20 flex flex-wrap gap-3 justify-end items-center bg-medieval-gold/5 -mx-6 -mb-6 px-6 py-4">
            <a href="{{ route('users.index') }}" class="mr-auto px-4 py-2 text-medieval-brown hover:text-medieval-gold transition-colors font-cinzel font-bold text-sm">
                <i class="ri-arrow-left-line mr-1"></i> Kembali
            </a>
            
            @if($user->status == 'pending')
            <form action="{{ route('users.approve', $user) }}" method="POST" class="inline">
                @csrf
                <x-medieval-button type="success" size="sm">
                    <i class="ri-check-line mr-1"></i> Resmikan
                </x-medieval-button>
            </form>
            <form action="{{ route('users.reject', $user) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Yakin ingin menolak pengguna ini?')">
                @csrf
                <x-medieval-button type="danger" size="sm">
                    <i class="ri-close-line mr-1"></i> Tolak
                </x-medieval-button>
            </form>
            @elseif($user->status == 'approved')
            <form action="{{ route('users.suspend', $user) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menangguhkan pengguna ini?')">
                @csrf
                <x-medieval-button type="danger" size="sm">
                    <i class="ri-forbid-line mr-1"></i> Asingkan (Suspend)
                </x-medieval-button>
            </form>
            @elseif($user->status == 'suspended')
            <form action="{{ route('users.unsuspend', $user) }}" method="POST" class="inline">
                @csrf
                <x-medieval-button type="success" size="sm">
                    <i class="ri-refresh-line mr-1"></i> Pulihkan
                </x-medieval-button>
            </form>
            @endif
            
            <form action="{{ route('users.reset-password', $user) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin reset password pengguna ini?')">
                @csrf
                <x-medieval-button type="outline" size="sm" class="border-medieval-gold/50 text-medieval-brown hover:bg-medieval-gold hover:text-white">
                    <i class="ri-key-2-line mr-1"></i> Reset Kunci
                </x-medieval-button>
            </form>
        </div>
    </x-medieval-card>
</div>
@endsection

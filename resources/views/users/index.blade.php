@extends('layouts.app')

@section('title', 'Daftar Pengguna')
@section('page-title', 'Registrasi Penduduk')

@section('content')
<x-medieval-card title="Buku Induk Penduduk" icon="ri-book-read-line">
    <x-slot name="actions">
        <div class="flex items-center space-x-2" x-data>
            <button type="button" @click="$dispatch('toggle-filter')" class="btn btn-outline btn-sm flex items-center shadow-gold border-medieval-gold text-medieval-brown hover:bg-medieval-gold hover:text-white transition-colors">
                <i class="ri-filter-3-line mr-2"></i>
                <span class="font-cinzel font-bold">Filter Pencarian</span>
            </button>
            <a href="{{ route('users.create-petugas') }}" class="btn btn-primary btn-sm flex items-center shadow-gold">
                <i class="ri-user-add-line mr-2"></i>
                <span class="font-cinzel font-bold">Lantik Petugas Baru</span>
            </a>
        </div>
    </x-slot>

    <div x-data="{ showFilter: false }" @toggle-filter.window="showFilter = !showFilter" class="relative z-20">
        <div x-show="showFilter" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-6 p-6 bg-[#FFF8DC] rounded-lg border-2 border-[#D4AF37] shadow-xl relative bg-parchment-texture">
            
            <!-- Close Button -->
            <button @click="showFilter = false" class="absolute top-2 right-2 text-[#8B4513] hover:text-red-600 transition-colors">
                <i class="ri-close-circle-fill text-xl"></i>
            </button>

            <h4 class="font-cinzel font-bold text-[#5D2E0C] mb-4 flex items-center">
                <i class="ri-search-eye-line mr-2 text-[#D4AF37]"></i> Filter Data Penduduk
            </h4>

            <form action="{{ route('users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-2 relative">
                    <label class="block font-cinzel text-xs font-bold text-[#5D2E0C] mb-1">Cari Nama/Email</label>
                    <div class="relative">
                        <i class="ri-search-2-line absolute left-3 top-1/2 transform -translate-y-1/2 text-[#5D2E0C]/50"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nama atau Email..." 
                               class="w-full pl-10 pr-4 py-2 rounded border border-[#D4AF37]/50 bg-white/50 focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] font-merriweather text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block font-cinzel text-xs font-bold text-[#5D2E0C] mb-1">Kasta</label>
                    <select name="role" class="w-full py-2 px-4 rounded border border-[#D4AF37]/50 bg-white/50 font-cinzel text-sm focus:ring-1 focus:ring-[#D4AF37]">
                        <option value="all">Semua Kasta</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin (Bangsawan)</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas (Ksatria)</option>
                        <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat (Rakyat)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block font-cinzel text-xs font-bold text-[#5D2E0C] mb-1">Status</label>
                    <select name="status" class="w-full py-2 px-4 rounded border border-[#D4AF37]/50 bg-white/50 font-cinzel text-sm focus:ring-1 focus:ring-[#D4AF37]">
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Diakui</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Diasingkan</option>
                    </select>
                </div>
                
                <div class="md:col-span-4 flex justify-end pt-2 border-t border-[#D4AF37]/20 mt-2">
                    <button type="button" @click="showFilter = false" class="mr-3 px-4 py-2 text-[#5D2E0C] font-bold font-cinzel text-sm hover:underline">Tutup</button>
                    <x-medieval-button type="primary" size="sm" icon="ri-filter-3-line">Terapkan Filter</x-medieval-button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="overflow-x-auto rounded-lg border border-medieval-gold/30 shadow-inner-parchment">
        <table class="table-medieval">
            <thead>
                <tr>
                    <th>Identitas Penduduk</th>
                    <th>Kasta / Peran</th>
                    <th>Status Kewarganegaraan</th>
                    <th>Terdaftar Sejak</th>
                    <th class="text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full bg-medieval-gold/20 flex items-center justify-center border border-medieval-gold shadow-sm">
                                <span class="font-cinzel font-bold text-medieval-brown">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-cinzel font-bold text-medieval-brown text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-medieval-slate/60 font-merriweather italic">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold font-cinzel tracking-wider
                            {{ $user->role == 'admin' ? 'bg-medieval-gold/20 text-medieval-brown border border-medieval-gold' : '' }}
                            {{ $user->role == 'petugas' ? 'bg-medieval-slate/10 text-medieval-slate border border-medieval-slate/30' : '' }}
                            {{ $user->role == 'masyarakat' ? 'bg-medieval-brown/5 text-medieval-brown border border-medieval-brown/10' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td><span class="badge badge-{{ $user->status }} capitalize font-bold text-[10px]">{{ ucfirst($user->status) }}</span></td>
                    <td class="font-merriweather text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="p-2 rounded-full hover:bg-medieval-gold/10 text-medieval-brown transition-colors" title="Lihat Profil">
                                <i class="ri-assignment-ind-line text-lg"></i>
                            </a>
                            @if($user->status == 'pending')
                            <form action="{{ route('users.approve', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 rounded-full hover:bg-medieval-forest/10 text-medieval-forest transition-colors" title="Beri Izin">
                                    <i class="ri-shield-check-line text-lg"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center text-medieval-slate/40">
                            <i class="ri-user-unfollow-line text-5xl mb-4 opacity-50"></i>
                            <p class="font-cinzel text-xl">Tidak Ada Penduduk</p>
                            <p class="text-sm">Belum ada warga yang terdaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @endif
</x-medieval-card>
@endsection

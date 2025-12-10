@extends('layouts.app')

@section('title', 'Kondisi')
@section('page-title', 'Kelola Kondisi Barang')

@section('content')
<div class="card relative overflow-visible">
    <!-- Wax Seal Decoration -->
    <div class="absolute -top-4 -right-4 z-20">
        <img src="{{ asset('images/wax-seal-gold.png') }}" class="w-16 h-16 drop-shadow-md opacity-90" alt="Seal">
    </div>

    <div class="card-header flex items-center justify-between border-b-2 border-[#D4AF37]/30 bg-[#FFF8DC] rounded-t-lg">
        <h3 class="font-cinzel font-bold text-[#5D2E0C] text-xl flex items-center">
            <i class="ri-shield-check-line mr-2 text-[#D4AF37]"></i>
            Daftar Standar Kualitas
        </h3>
        <a href="{{ route('conditions.create') }}" class="group relative px-6 py-2 bg-[#8B4513] text-[#D4AF37] font-cinzel font-bold text-sm tracking-wider rounded border-2 border-[#D4AF37] shadow-[0_4px_0_#5D2E0C] hover:shadow-[0_2px_0_#5D2E0C] hover:translate-y-[2px] active:shadow-none active:translate-y-[4px] transition-all overflow-visible md:mr-4">
            <span class="relative z-10 flex items-center">
                <i class="ri-add-circle-fill mr-2"></i>
                TAMBAH KONDISI
            </span>
            <div class="absolute -right-3 -top-3 transform rotate-12 group-hover:rotate-0 transition-transform z-20">
                <img src="{{ asset('images/wax-seal-gold.png') }}" class="w-8 h-8 drop-shadow-md" alt="Seal">
            </div>
            <div class="absolute inset-0 bg-[#D4AF37] opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded"></div>
        </a>
    </div>
    
    <div class="overflow-x-auto bg-parchment-texture p-4 rounded-b-lg">
        <table class="table-medieval w-full">
            <thead>
                <tr class="bg-[#D4AF37]/20 border-b-2 border-[#D4AF37]">
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Nama</th>
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Deskripsi</th>
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Rating Kualitas</th>
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Jumlah Item</th>
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Status</th>
                    <th class="p-4 text-left font-cinzel font-bold text-[#F4C430]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#D4AF37]/20">
                @forelse($conditions as $condition)
                <tr class="hover:bg-[#D4AF37]/5 transition-colors">
                    <td class="p-4 font-medium font-merriweather text-[#5D2E0C]">{{ $condition->name }}</td>
                    <td class="p-4 text-sm text-[#5D2E0C]/80 italic">{{ Str::limit($condition->description, 50) ?? '-' }}</td>
                    <td class="p-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 10; $i++)
                                <i class="ri-star-{{ $i <= $condition->quality_rating ? 'fill' : 'line' }} text-[#D4AF37] text-xs"></i>
                            @endfor
                            <span class="ml-2 font-bold text-[#8B4513]">({{ $condition->quality_rating }}/10)</span>
                        </div>
                    </td>
                    <td class="p-4 text-center font-bold text-[#5D2E0C]">{{ $condition->items_count }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $condition->is_active ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}">
                            {{ $condition->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('conditions.edit', $condition) }}" class="p-2 text-[#8B4513] hover:text-[#D4AF37] transition-colors border border-[#D4AF37]/50 rounded hover:bg-[#5D2E0C] hover:border-[#5D2E0C]">
                                <i class="ri-quill-pen-line"></i>
                            </a>
                            <form action="{{ route('conditions.toggle', $condition) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $condition->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }} transition-colors border border-current rounded opacity-70 hover:opacity-100">
                                    <i class="ri-{{ $condition->is_active ? 'close' : 'check' }}-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-[#5D2E0C]/60 italic font-merriweather">
                        <i class="ri-scroll-line text-4xl mb-3 opacity-50 block"></i>
                        Belum ada maklumat kondisi yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($conditions->hasPages())
    <div class="card-footer bg-[#FFF8DC] border-t border-[#D4AF37]/30 p-4">
        {{ $conditions->links() }}
    </div>
    @endif
</div>
@endsection

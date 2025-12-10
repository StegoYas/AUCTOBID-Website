@extends('layouts.app')

@section('title', 'Arsip Laporan')
@section('page-title', 'Arsip Laporan Kerajaan')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Decor -->
    <div class="text-center mb-12 relative">
        <div class="absolute top-1/2 left-0 w-full h-px bg-[#D4AF37]/30"></div>
        <div class="relative inline-block bg-[#FFF8DC] px-6 py-2 border-2 border-[#D4AF37] rounded-full z-10 box-decoration-clone">
            <h2 class="font-cinzel text-2xl font-bold text-[#8B4513] uppercase tracking-widest flex items-center gap-3">
                <i class="ri-quill-pen-fill text-[#D4AF37]"></i>
                Catatan Resmi Kerajaan
                <i class="ri-quill-pen-fill text-[#D4AF37] transform scale-x-[-1]"></i>
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Users Report Scroll -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#D4AF37] to-[#8B4513] rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-500"></div>
            <div class="relative bg-[#FFF8DC] border-2 border-[#D4AF37] rounded-lg p-6 bg-parchment-texture shadow-xl">
                <!-- Wax Seal -->
                <div class="absolute -top-3 -right-3 z-20">
                    <img src="{{ asset('images/wax-seal-red.png') }}" class="w-16 h-16 drop-shadow-md opacity-90" alt="Seal">
                </div>
                
                <div class="border-b border-[#D4AF37]/30 pb-4 mb-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center border border-[#D4AF37] mr-4">
                        <i class="ri-user-star-line text-2xl text-[#8B4513]"></i>
                    </div>
                    <div>
                        <h3 class="font-cinzel font-bold text-xl text-[#5D2E0C]">Sensus Penduduk</h3>
                        <p class="text-xs font-merriweather italic text-[#8B4513]/70">Laporan Warga & Pejabat</p>
                    </div>
                </div>

                <form action="{{ route('reports.users') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Kasta</label>
                            <select name="role" class="w-full bg-white/50 border border-[#D4AF37] rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37] font-merriweather">
                                <option value="all">Semua Kasta</option>
                                <option value="admin">Bangsawan (Admin)</option>
                                <option value="petugas">Ksatria (Petugas)</option>
                                <option value="masyarakat">Rakyat (Masyarakat)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Status</label>
                            <select name="status" class="w-full bg-white/50 border border-[#D4AF37] rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37] font-merriweather">
                                <option value="all">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="approved">Diakui</option>
                                <option value="suspended">Diasingkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-4 bg-[#D4AF37]/5 rounded border border-[#D4AF37]/20">
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Dari Masa</label>
                            <input type="date" name="from_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Hingga Masa</label>
                            <input type="date" name="to_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="format" value="pdf" class="flex-1 flex items-center justify-center gap-2 bg-[#8B4513] text-[#D4AF37] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#5D2E0C] transition-colors shadow-sm">
                            <i class="ri-file-pdf-line"></i> CETAK PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="flex-1 flex items-center justify-center gap-2 bg-[#D4AF37]/20 text-[#5D2E0C] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#D4AF37]/30 transition-colors">
                            <i class="ri-file-excel-line"></i> CETAK EXCEL
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Auctions Report Scroll -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#D4AF37] to-[#8B4513] rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-500"></div>
            <div class="relative bg-[#FFF8DC] border-2 border-[#D4AF37] rounded-lg p-6 bg-parchment-texture shadow-xl">
                 <!-- Wax Seal -->
                 <div class="absolute -top-3 -right-3 z-20">
                    <img src="{{ asset('images/wax-seal-gold.png') }}" class="w-16 h-16 drop-shadow-md opacity-90" alt="Seal">
                </div>

                <div class="border-b border-[#D4AF37]/30 pb-4 mb-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center border border-[#D4AF37] mr-4">
                        <i class="ri-auction-fill text-2xl text-[#8B4513]"></i>
                    </div>
                    <div>
                        <h3 class="font-cinzel font-bold text-xl text-[#5D2E0C]">Riwayat Pelelangan</h3>
                        <p class="text-xs font-merriweather italic text-[#8B4513]/70">Laporan Aktivitas Lelang</p>
                    </div>
                </div>
                
                <form action="{{ route('reports.auctions') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Status Lelang</label>
                        <select name="status" class="w-full bg-white/50 border border-[#D4AF37] rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37] font-merriweather">
                            <option value="all">Semua Status</option>
                            <option value="scheduled">Terjadwal</option>
                            <option value="active">Sedang Berlangsung</option>
                            <option value="ended">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 p-4 bg-[#D4AF37]/5 rounded border border-[#D4AF37]/20">
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Dari Masa</label>
                            <input type="date" name="from_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Hingga Masa</label>
                            <input type="date" name="to_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="format" value="pdf" class="flex-1 flex items-center justify-center gap-2 bg-[#8B4513] text-[#D4AF37] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#5D2E0C] transition-colors shadow-sm">
                            <i class="ri-file-pdf-line"></i> CETAK PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="flex-1 flex items-center justify-center gap-2 bg-[#D4AF37]/20 text-[#5D2E0C] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#D4AF37]/30 transition-colors">
                            <i class="ri-file-excel-line"></i> CETAK EXCEL
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Items Report Scroll -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#D4AF37] to-[#8B4513] rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-500"></div>
            <div class="relative bg-[#FFF8DC] border-2 border-[#D4AF37] rounded-lg p-6 bg-parchment-texture shadow-xl">
                <div class="border-b border-[#D4AF37]/30 pb-4 mb-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center border border-[#D4AF37] mr-4">
                        <i class="ri-treasure-map-fill text-2xl text-[#8B4513]"></i>
                    </div>
                    <div>
                        <h3 class="font-cinzel font-bold text-xl text-[#5D2E0C]">Inventaris Barang</h3>
                        <p class="text-xs font-merriweather italic text-[#8B4513]/70">Laporan Harta & Artefak</p>
                    </div>
                </div>
                
                <form action="{{ route('reports.items') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Status Barang</label>
                        <select name="status" class="w-full bg-white/50 border border-[#D4AF37] rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37] font-merriweather">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Penilaian</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="auctioning">Sedang Dilelang</option>
                            <option value="sold">Terjual</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 p-4 bg-[#D4AF37]/5 rounded border border-[#D4AF37]/20">
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Dari Masa</label>
                            <input type="date" name="from_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Hingga Masa</label>
                            <input type="date" name="to_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="format" value="pdf" class="flex-1 flex items-center justify-center gap-2 bg-[#8B4513] text-[#D4AF37] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#5D2E0C] transition-colors shadow-sm">
                            <i class="ri-file-pdf-line"></i> CETAK PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="flex-1 flex items-center justify-center gap-2 bg-[#D4AF37]/20 text-[#5D2E0C] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#D4AF37]/30 transition-colors">
                            <i class="ri-file-excel-line"></i> CETAK EXCEL
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Transactions Report Scroll -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#D4AF37] to-[#8B4513] rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-500"></div>
            <div class="relative bg-[#FFF8DC] border-2 border-[#D4AF37] rounded-lg p-6 bg-parchment-texture shadow-xl">
                <div class="border-b border-[#D4AF37]/30 pb-4 mb-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center border border-[#D4AF37] mr-4">
                        <i class="ri-coins-fill text-2xl text-[#8B4513]"></i>
                    </div>
                    <div>
                        <h3 class="font-cinzel font-bold text-xl text-[#5D2E0C]">Buku Kas Kerajaan</h3>
                        <p class="text-xs font-merriweather italic text-[#8B4513]/70">Laporan Keuangan & Transaksi</p>
                    </div>
                </div>
                
                <form action="{{ route('reports.transactions') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full bg-white/50 border border-[#D4AF37] rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37] font-merriweather">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Pembayaran</option>
                            <option value="paid">Lunas (Upeti Diterima)</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 p-4 bg-[#D4AF37]/5 rounded border border-[#D4AF37]/20">
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Dari Masa</label>
                            <input type="date" name="from_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block font-cinzel text-xs font-bold text-[#8B4513] mb-1">Hingga Masa</label>
                            <input type="date" name="to_date" class="w-full bg-white/50 border border-[#D4AF37] rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="format" value="pdf" class="flex-1 flex items-center justify-center gap-2 bg-[#8B4513] text-[#D4AF37] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#5D2E0C] transition-colors shadow-sm">
                            <i class="ri-file-pdf-line"></i> CETAK PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="flex-1 flex items-center justify-center gap-2 bg-[#D4AF37]/20 text-[#5D2E0C] py-2 rounded border border-[#D4AF37] font-cinzel text-sm font-bold hover:bg-[#D4AF37]/30 transition-colors">
                            <i class="ri-file-excel-line"></i> CETAK EXCEL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

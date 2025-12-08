@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Users Report -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-user-line mr-2"></i>
                Laporan Pengguna
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.users') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Role</label>
                        <select name="role" class="form-input">
                            <option value="all">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="masyarakat">Masyarakat</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="from_date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="to_date" class="form-input">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" name="format" value="pdf" class="btn btn-primary flex-1">
                            <i class="ri-file-pdf-line mr-2"></i> PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="btn btn-secondary flex-1">
                            <i class="ri-file-excel-line mr-2"></i> Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Auctions Report -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-hammer-line mr-2"></i>
                Laporan Lelang
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.auctions') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="all">Semua Status</option>
                            <option value="scheduled">Terjadwal</option>
                            <option value="active">Aktif</option>
                            <option value="ended">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="from_date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="to_date" class="form-input">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" name="format" value="pdf" class="btn btn-primary flex-1">
                            <i class="ri-file-pdf-line mr-2"></i> PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="btn btn-secondary flex-1">
                            <i class="ri-file-excel-line mr-2"></i> Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Items Report -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-archive-line mr-2"></i>
                Laporan Barang
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.items') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="auctioning">Dilelang</option>
                            <option value="sold">Terjual</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="from_date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="to_date" class="form-input">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" name="format" value="pdf" class="btn btn-primary flex-1">
                            <i class="ri-file-pdf-line mr-2"></i> PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="btn btn-secondary flex-1">
                            <i class="ri-file-excel-line mr-2"></i> Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Transactions Report -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-cinzel font-semibold text-medieval-brown">
                <i class="ri-exchange-dollar-line mr-2"></i>
                Laporan Transaksi
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.transactions') }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-input">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="paid">Lunas</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="from_date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="to_date" class="form-input">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" name="format" value="pdf" class="btn btn-primary flex-1">
                            <i class="ri-file-pdf-line mr-2"></i> PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="btn btn-secondary flex-1">
                            <i class="ri-file-excel-line mr-2"></i> Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

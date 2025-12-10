<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lelang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #333; }
        .meta { margin-bottom: 20px; }
        .summary { margin-top: 20px; border-top: 2px solid #333; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>Laporan Lelang AUCTOBID</h1>
    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i') }}<br>
        <strong>Total Lelang:</strong> {{ $auctions->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Pelelang</th>
                <th>Status</th>
                <th>Harga Akhir</th>
                <th>Pemenang</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auctions as $index => $auction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $auction->item->name }}</td>
                <td>{{ $auction->openedBy->name }}</td>
                <td>{{ ucfirst($auction->status) }}</td>
                <td>Rp {{ number_format($auction->final_price ?? 0, 0, ',', '.') }}</td>
                <td>{{ $auction->winner->name ?? '-' }}</td>
                <td>{{ $auction->closed_at ? $auction->closed_at->format('d-m-Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Pendapatan (Harga Akhir):</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}<br>
        <strong>Total Komisi:</strong> Rp {{ number_format($totalCommission, 0, ',', '.') }}
    </div>
</body>
</html>

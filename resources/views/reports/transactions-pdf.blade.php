<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
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
    <h1>Laporan Transaksi AUCTOBID</h1>
    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i') }}<br>
        <strong>Total Transaksi:</strong> {{ $transactions->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Pemenang</th>
                <th>Harga Akhir</th>
                <th>Komisi</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->item->name }}</td>
                <td>{{ $transaction->winner->name }}</td>
                <td>Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($transaction->commission_amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($transaction->payment_status) }}</td>
                <td>{{ $transaction->closed_at ? $transaction->closed_at->format('d-m-Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Transaksi:</strong> Rp {{ number_format($totalAmount, 0, ',', '.') }}<br>
        <strong>Total Terbayar:</strong> Rp {{ number_format($paidAmount, 0, ',', '.') }}<br>
        <strong>Total Komisi:</strong> Rp {{ number_format($totalCommission, 0, ',', '.') }}
    </div>
</body>
</html>

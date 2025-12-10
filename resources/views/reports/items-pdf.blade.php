<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #333; }
        .meta { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Barang AUCTOBID</h1>
    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i') }}<br>
        <strong>Total Barang:</strong> {{ $items->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Pemilik</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Harga Awal</th>
                <th>Status</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->condition->name ?? '-' }}</td>
                <td>Rp {{ number_format($item->starting_price, 0, ',', '.') }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

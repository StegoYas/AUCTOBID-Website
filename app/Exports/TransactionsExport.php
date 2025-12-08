<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'ID Lelang',
            'Nama Barang',
            'Pemenang',
            'Harga Akhir',
            'Komisi',
            'Status Bayar',
            'Tanggal Transaksi',
        ];
    }

    public function map($auction): array
    {
        return [
            $auction->id,
            $auction->item->name ?? '-',
            $auction->winner->name ?? '-',
            'Rp ' . number_format($auction->final_price, 0, ',', '.'),
            'Rp ' . number_format($auction->commission_amount ?? 0, 0, ',', '.'),
            ucfirst($auction->payment_status ?? 'pending'),
            $auction->closed_at ? $auction->closed_at->format('d/m/Y H:i') : '-',
        ];
    }
}

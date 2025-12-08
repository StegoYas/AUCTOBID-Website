<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuctionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $auctions;

    public function __construct(Collection $auctions)
    {
        $this->auctions = $auctions;
    }

    public function collection()
    {
        return $this->auctions;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Kategori',
            'Harga Awal',
            'Harga Akhir',
            'Komisi',
            'Status',
            'Pemenang',
            'Status Bayar',
            'Mulai',
            'Selesai',
        ];
    }

    public function map($auction): array
    {
        return [
            $auction->id,
            $auction->item->name ?? '-',
            $auction->item->category->name ?? '-',
            'Rp ' . number_format($auction->starting_price, 0, ',', '.'),
            $auction->final_price ? 'Rp ' . number_format($auction->final_price, 0, ',', '.') : '-',
            $auction->commission_amount ? 'Rp ' . number_format($auction->commission_amount, 0, ',', '.') : '-',
            ucfirst($auction->status),
            $auction->winner->name ?? '-',
            ucfirst($auction->payment_status ?? '-'),
            $auction->start_time->format('d/m/Y H:i'),
            $auction->end_time->format('d/m/Y H:i'),
        ];
    }
}

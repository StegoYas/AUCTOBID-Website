<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Pemilik',
            'Kategori',
            'Kondisi',
            'Harga Awal',
            'Status',
            'Tanggal Ajukan',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->user->name ?? '-',
            $item->category->name ?? '-',
            $item->condition->name ?? '-',
            'Rp ' . number_format($item->starting_price, 0, ',', '.'),
            ucfirst($item->status),
            $item->created_at->format('d/m/Y H:i'),
        ];
    }
}

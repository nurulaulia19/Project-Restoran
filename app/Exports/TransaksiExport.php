<?php
namespace App\Exports;

use App\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    protected $transaksis;

    public function __construct(Collection $transaksis)
    {
        $this->transaksis = $transaksis;
    }

    public function collection()
    {
        return $this->transaksis;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kasir',
            'Tanggal',
            'No Meja',
            'Status',
            'Diskon',
            'Total Harga',
            'Total Bayar',
            'Total Kembalian',
        ];
    }
}


<?php
namespace App\Exports;

use App\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataTransaksi;
    protected $totalBayar;
    protected $totalKembalian;

    public function __construct($dataTransaksi, $totalBayar, $totalKembalian)
    {
        $this->dataTransaksi = $dataTransaksi;
        $this->totalBayar = $totalBayar;
        $this->totalKembalian = $totalKembalian;
    }

    public function view(): View
    {
        return view('laporan.eksportTransaksi', [
            'dataTransaksi' => $this->dataTransaksi,
            'totalBayar' => $this->totalBayar,
            'totalKembalian' => $this->totalKembalian,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->dataTransaksi) + 4; // Include four additional rows
    
        return [
            // Apply borders to the entire table, including two additional rows at the bottom
            'A3:I' . $rowCount => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'font' => [
                    'size' => 11, // Adjust the font size for most cells
                ],
            ],
        ];
    }
    
    


    
}


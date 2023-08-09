<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\DataProduk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProdukExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataProduk;

    public function __construct($dataProduk)
    {
        $this->dataProduk = $dataProduk;
    }

    public function view(): View
    {
        return view('laporan.eksportProduk', [
            'dataProduk' => $this->dataProduk,
        ]);
    }

    public function styles(Worksheet $sheet)
{
    $rowCount = count($this->dataProduk) + 4; // Include three additional empty rows

    // Apply borders and font styling to each cell within the specified range
    for ($row = 3; $row <= $rowCount; $row++) { // Start from row 2 to exclude the title
        for ($col = 'A'; $col <= 'D'; $col++) {
            $cellCoordinate = $col . $row;
            $sheet->getStyle($cellCoordinate)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'font' => [
                    'size' => 11,
                ],
            ]);
        }
    }

    $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        // Center-align the merged cells content
        $sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}



}



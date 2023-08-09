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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TransaksiExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
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
    
        $styles = [
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

        // Merge cells for the first two rows
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');

        // Center-align the merged cells content
        $sheet->getStyle('A1:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return $styles;
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_harga'
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_bayar'
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // 'total_kembalian'
        ];
    }
    
    


    
}


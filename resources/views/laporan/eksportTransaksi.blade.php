<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Laporan Transaksi</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
   
    <style>
        /* Add borders to the entire table */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
            
        }

        /* Style for table header cells */
        .table-bordered th {
            border: 1px solid black;
            padding: 8px;
            
        }

        /* Style for table data cells */
        .table-bordered td {
            border: 1px solid black;
            padding: 8px;

        }

    </style>
    
  </head>
  <body>
    <div class="table-responsive mx-auto">
        <h3 class="mb-3" style="text-align: center">Laporan Transaksi</h3>
        @php
        if (request('start_date') && request('end_date')) {
            $startDate = request('start_date');
            $endDate = request('end_date');
        }
        $ketMakanan = request('ket_makanan');
        @endphp

        <h5 class="mb-3" style="text-align: center">
            @if(isset($startDate) && isset($endDate))
                Dalam rentang tanggal dari {{ $startDate }} hingga {{ $endDate }} dan 
            @endif

            status pemesanan
            @php
                $statusPemesanan = isset($ketMakanan) ? $ketMakanan : 'semua';
                if (!in_array($statusPemesanan, ['dine in', 'take away'])) {
                    $statusPemesanan = 'semua';
                }
            @endphp
            {{ $statusPemesanan }}
        </h5>

        <table class="table table-bordered">
            <thead data-testid="table-header">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Kasir</th>
                    <th>No Meja</th>
                    <th>Status</th>
                    <th>Diskon</th>
                    <th>Total Harga</th>
                    <th>Total Bayar</th>
                    <th>Total Kembalian</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($dataTransaksi as $item)
                <tr style="font-size:13px;">
                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td style="vertical-align: middle;">{{ $item->tanggal_transaksi }}</td>
                    <td style="vertical-align: middle;">{{ $item->user->user_name }}</td>                                                      
                    <td style="vertical-align: middle; text-align: center;">{{ $item->no_meja }}</td>
                    <td style="vertical-align: middle;">{{ $item->ket_makanan }}</td>
                    <td style="vertical-align: middle; text-align: center;">{{ $item->diskon_transaksi }} %</td>
                    <td style="vertical-align: middle; text-align: center;">
                        @if(app('request')->route()->getName() !== 'export.excel')
                            {{ number_format($item->total_harga, 2, ',', '.') }}
                        @else
                            {!! $item->total_harga !!}
                        @endif
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        @if(app('request')->route()->getName() !== 'export.excel')
                            {{ number_format($item->total_bayar, 2, ',', '.') }}
                        @else
                            {!! $item->total_bayar !!}
                        @endif
                    </td>
                    <td style="vertical-align: middle; text-align: center;">
                        @if(app('request')->route()->getName() !== 'export.excel')
                            {{ number_format($item->total_kembalian, 2, ',', '.') }}
                        @else
                            {!! $item->total_kembalian !!}
                        @endif
                    </td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="font-size: 13px;">Grand Total</td>
                    <td style="text-align: center; font-size: 13px;">
                        @if(app('request')->route()->getName() !== 'export.excel')
                            {{ number_format($totalBayar, 2, ',', '.') }}
                        @else
                            {!! $totalBayar !!}
                        @endif
                        {{-- {{ number_format($totalBayar, 0, ',', '.') }} --}}
                    </td>
                    <td style="text-align: center; font-size: 13px;">
                        @if(app('request')->route()->getName() !== 'export.excel')
                            {{ number_format($totalKembalian, 2, ',', '.') }}
                        @else
                            {!! $totalKembalian !!}
                        @endif
                        {{-- {{ number_format($totalKembalian, 0, ',', '.') }} --}}
                    </td>
                </tr>
            </tfoot>
            
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>


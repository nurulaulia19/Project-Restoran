<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
        <h3 class="mb-3" style="text-align: center">Laporan Produk</h3>
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


        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @php
                $grandTotalJumlahProduk = 0; // Inisialisasi grand total jumlah produk
                @endphp
                @foreach ($dataProduk as $item)
                    @php
                    $filteredStatus = session('status');
                    $totalJumlahProduk = 0; // Inisialisasi total jumlah produk
                    @endphp
                    <tr>
                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                        <td style="vertical-align: middle;">
                            @if ($item->kategori)
                                {{ $item->kategori->nama_kategori }}
                            @else
                                Kategori not assigned
                            @endif
                        </td>
                        <td style="vertical-align: middle;">{{ $item->nama_produk }}</td>
                        @foreach ($item->transaksiDetail as $transaksiDetail)
                            @if ($transaksiDetail->transaksi->tanggal_transaksi >= session('start_date') && $transaksiDetail->transaksi->tanggal_transaksi <= session('end_date'))
                                @if (!$filteredStatus || ($filteredStatus && $transaksiDetail->transaksi->ket_makanan == $filteredStatus))
                                    @php
                                    $totalJumlahProduk += $transaksiDetail->jumlah_produk;
                                    $grandTotalJumlahProduk += $transaksiDetail->jumlah_produk;
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                        <td style="vertical-align: middle;">{{ $totalJumlahProduk }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: left;">Grand Total</td>
                    <td>{{ $grandTotalJumlahProduk }}</td>
                </tr>
                </tbody>
        </table>
    
    </div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <title>Resi Transaksi</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Set the height of the body to 100% of the viewport height */
        }
        .resi-container {
            width: 10cm;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
        }
        .resi-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .resi-label {
            font-size: 12px;
            font-weight: bold;
        }
        .resi-value {
            font-size: 12px;
        }
        .resi-action {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>
    @if($dataTransaksi)
    @foreach($dataTransaksi as $item)
        <div class="resi-container">
            <div class="resi-header">
                @foreach($dataToko as $toko)
                    <img style="width: 50px; height: 50px; margin-bottom: 0px;" src="{{ asset('storage/photos/'.basename($toko->logo)) }}" alt="Logo Toko">
                @endforeach
            </div>
            <div class="resi-header">
                @foreach($dataToko as $toko)
                {{ $toko->nama_toko }}
                @endforeach
            </div>
            {{-- <div class="resi-label">Id Transaksi</div>
            <div class="resi-value">{{ $item->id_transaksi }}</div> --}}
            <div class="resi-label">Tanggal Transaksi</div>
            <div class="resi-value">{{ $item->tanggal_transaksi }}</div>
            <div class="resi-label">Nama Kasir</div>
            <div class="resi-value">{{ $item->user->user_name }}</div>
            <hr>
            {{-- <div class="resi-label">Makanan --}}
            <div class="resi-value">
                {{-- @if ($item->transaksiDetail)
                    @foreach ($item->transaksiDetail as $detail)
                <table class="table">
                    <tbody>
                      <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                  @endforeach
                @else
                    Produk not assigned
                @endif --}}


                @if ($item->transaksiDetail)
                    @foreach ($item->transaksiDetail as $detail)
                        <div>{{ $detail->jumlah_produk }}</div>
                        <div>{{ $detail->produk->nama_produk }}</div>
                        <div>{{ $detail->produk->harga_produk }}</div>
                        <div>
                            @if ($detail->transaksiDetailAditional) {{-- Use $detail here, not $item --}}
                                @foreach ($detail->transaksiDetailAditional as $additional) {{-- Use $additional, not $detail --}}
                                    <div>{{ $additional->dataAditional->nama_aditional }}</div>
                                    <div>{{ $additional->dataAditional->harga_aditional }}</div>
                                @endforeach
                            @else
                                Aditional not assigned
                            @endif
                            <div>
                                @php
                                $hargaProduk = $detail->produk->harga_produk;
                                $diskonProduk = $detail->produk->diskon_produk; // Diskon produk dalam persen
                                $jumlahProduk = $detail->jumlah_produk;
                                $totalHargaSebelumDiskon = $hargaProduk * $jumlahProduk;
                            
                                // Hitung total harga additional
                                $totalHargaAdditional = 0;
                                if ($detail->transaksiDetailAditional) {
                                    foreach ($detail->transaksiDetailAditional as $items) {
                                        $hargaAditional = $items->dataAditional->harga_aditional;
                                        $diskonAditional = $items->dataAditional->diskon_aditional; // Diskon aditional dalam persen
                                        $totalHargaAdditional += $hargaAditional * $jumlahProduk * (1 - $diskonAditional / 100);
                                    }
                                }
                            
                                // Hitung besaran diskon dalam bentuk nominal untuk produk dan aditional jika ada diskon
                                $diskonNominalProduk = $totalHargaSebelumDiskon * $diskonProduk / 100;
                                $diskonNominalAditional = $totalHargaAdditional * $diskonProduk / 100;
                            
                                // Hitung total harga setelah diskon, termasuk diskon untuk produk dan aditional
                                $totalHargaSetelahDiskon = $totalHargaSebelumDiskon - $diskonNominalProduk + $totalHargaAdditional - $diskonNominalAditional;
                                @endphp
                            
                                {{ number_format($totalHargaSetelahDiskon, 0, ',', '.') }} 
                            </div>
                        </div>
                    @endforeach
                @else
                    Produk not assigned
                @endif
            </div>
            <hr>
            <div class="resi-label">Keterangan Makanan</div>
            <div class="resi-value">{{ $item->ket_makanan }}</div>
            <div class="resi-label">Diskon Transaksi</div>
            <div class="resi-value">{{ $item->diskon_transaksi }} %</div>
            <div class="resi-label">Total Harga</div>
            <div class="resi-value">{{ number_format($item->total_harga, 0, ',', '.') }}</div>
            <div class="resi-label">Total Bayar</div>
            <div class="resi-value">{{ number_format($item->total_bayar, 0, ',', '.') }}</div>
            <div class="resi-label">Total Kembalian</div>
            <div class="resi-value">{{ number_format($item->total_kembalian, 0, ',', '.') }}</div>
            {{-- <div class="resi-action">
                <button onclick="printContent()" class="btn">Cetak</button>
            </div> --}}
        </div>
    @endforeach
    @else
        <p>No transactions found.</p>
    @endif
    {{-- <script>
        function printContent() {
            window.print();
        }
    </script> --}}
</body>
</html>

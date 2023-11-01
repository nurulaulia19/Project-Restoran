<!DOCTYPE html>
<html>
<head>
    
    <title>Resi Transaksi</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        td {
            /* text-align: center; */
            padding: 8px;
            /* border: 1px solid black; */
            font-weight: normal;
            /* background-color: #f2f2f2; */
            
    
            /* vertical-align: top; */
        }

        /* CSS untuk sel data */
        td.data {
            font-weight: normal;
            background-color: white;
            
        }

        body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Set the height of the body to 100% of the viewport height */
        margin: 0;
        }
        .resi-container {
            width: 10cm;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            position: absolute;
            top: 33%; /* Posisikan di tengah secara vertikal */
            left: 50%; /* Posisikan di tengah secara horizontal */
            transform: translate(-50%, -50%); /* Geser agar tepat berada di atas tengah */
        }
        .resi-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .resi-header-toko{
            font-family: Playfair Display;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .resi-label {
            font-size: 12px;
            font-weight: bold;
            margin-right: 5px;

        }
        .resi-value {
            font-size: 12px;
            text-transform: capitalize;
           
        }

        .resi-value-footer{
            font-size: 12px;
            font-weight: bold;
        }

        .resi-item {
            display: flex;
            align-items: center;
            margin-top: auto;
        
        }

        .container {
        display: flex;
        flex-wrap: wrap;
        }

        .row {
        flex: 1;
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px; /* Atur margin antar baris sesuai kebutuhan */
        }

        .column {
        flex: 1;
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

        td.jumlah {
            width: 20px; /* Sesuaikan ukuran kolom yang diinginkan */
            
        }

        /* td div {
            display: inline;
        
        } */

        .resi-body {
        flex-wrap: wrap;
        margin-top: 10px;
    }
    </style>
</head>
<body>
    @if($dataTransaksi)
    @foreach($dataTransaksi as $item)
        <div class="resi-container">
            <div class="resi-header">
                @foreach($dataToko as $toko)
                    <img style="width: 55px; height: 35px; margin-bottom: 0px; margin-top:10px" src="{{ asset('storage/photos/'.basename($toko->logo)) }}" alt="Logo Toko">
                @endforeach
            </div>
            <div class="resi-header-toko">
                @foreach($dataToko as $toko)
                {{ $toko->nama_toko }}
                @endforeach
            </div>
            {{-- <div class="resi-label">Id Transaksi</div>
            <div class="resi-value">{{ $item->id_transaksi }}</div> --}}
            <div class="resi-body">
                <div class="resi-item">
                    <div class="resi-label">Tanggal Transaksi :</div>
                    <div class="resi-value">{{ $item->tanggal_transaksi }}</div>
                </div>
                <div class="resi-item">
                    <div class="resi-label">Status :</div>
                    <div class="resi-value">{{ $item->ket_makanan }}</div>
                </div>
                <div class="resi-item">
                    @if ($item->no_meja !== null)
                        <div class="resi-label">No Meja :</div>
                        <div class="resi-value">{{ $item->no_meja }}</div>
                    @endif
                </div>
                <div class="resi-item">
                    <div class="resi-label">Nama Kasir :</div>
                    <div class="resi-value">{{ $item->user->user_name }}</div>
                </div>  
            </div>
                      
            <hr>
            {{-- <div class="resi-label">Makanan --}}
            <div class="resi-value">
                @if ($item->transaksiDetail)
                    @foreach ($item->transaksiDetail as $detail)
                <table class="table">
                    <tbody>
                      <tr>
                        <td class="jumlah">{{ $detail->jumlah_produk }}</td>
                        <td class="nama" style="word-wrap: break-word; white-space: normal;">{{ $detail->produk->nama_produk }}
                            <div>
                                @if ($detail->transaksiDetailAditional) {{-- Use $detail here, not $item --}}
                                @foreach ($detail->transaksiDetailAditional as $additional) {{-- Use $additional, not $detail --}}
                                <div style="display: flex; align-items: center;">
                                    <div>{{ $additional->dataAditional->nama_aditional }}</div>
                                    <div style="margin-left: 5px;">{{ number_format($additional->dataAditional->harga_aditional, 0, ',', '.') }}</div>
                                </div>
                                @endforeach
                            @else
                            Aditional not assigned
                            @endif 
                            </div>
                        </td>
                        <td style="text-align: right;">{{ number_format($detail->produk->harga_produk, 0, ',', '.') }}</td>
                        <td style="text-align: right;">
                            @if ($detail->produk->diskon_produk > 0)
                            <div class="resi-value">{{ $detail->produk->diskon_produk }} %</div>
                            @endif
                        </td>
                        
                        <td style="text-align: right;">
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
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  @endforeach
                @else
                    Produk not assigned
                @endif    
            </div>
            <hr>
            <div class="container">
                <div class="row">
                  <div class="column">
                    
                    <div class="resi-label">
                        @if ($item->diskon_transaksi > 0)
                            <div class="resi-label">Diskon</div>
                        @endif
                    </div>
                    <div class="resi-label">Total Harga</div>
                    <div class="resi-label">Total Bayar</div>
                    <div class="resi-label">Total Kembalian</div>
                  </div>
                  <div class="column">
                    
                    {{-- <div style="text-align: right; background-color:red" class="resi-value">{{ $item->jumlahItems }}</div> --}}
                    <div style="text-align: right;" class="resi-value-footer">
                        @if ($item->diskon_transaksi > 0)
                            <div class="resi-value">{{ $item->diskon_transaksi }} %</div>
                        @endif
                        
                        {{-- {{ $item->diskon_transaksi }} % --}}
                    </div>
                    {{-- <div style="text-align: right;" class="resi-value">4</div> --}}
                    <div style="text-align: right;" class="resi-value-footer">{{ number_format($item->total_harga, 0, ',', '.') }}</div>
                    <div style="text-align: right;" class="resi-value-footer">{{ number_format($item->total_bayar, 0, ',', '.') }}</div>
                    <div style="text-align: right;" class="resi-value-footer">{{ number_format($item->total_kembalian, 0, ',', '.') }}</div>
                  </div>
                </div>
            
              </div>
              <hr>
              <div class="resi-footer" style="text-align: center; font-size:15px">
                <p>Terima kasih</p>
                <p>Atas Kunjungan Anda</p>
              </div>
            {{-- <div class="resi-harga" style="background-color:red;">
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
                </div>
            <div class="resi-action">
                <button onclick="printContent()" class="btn">Cetak</button>
            </div>
        </div> --}}
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

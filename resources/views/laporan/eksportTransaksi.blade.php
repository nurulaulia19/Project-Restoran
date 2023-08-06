<div class="table-responsive">
    <table class="table table-striped">
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
                <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_kembalian, 0, ',', '.') }}</td>
                <td class="table-action" style="vertical-align: middle;">
                    {{-- <div style="display:flex; align-items:center; justify-content:">
                        <a style="margin-right: 10px;" href="{{ route( 'transaksi.edit', $item->id_transaksi) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route( 'transaksi.destroy', $item->id_transaksi) }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_transaksi }})">Hapus</a>
                        <div class="resi-container">
                            <button onclick="printReceipt({{ $item->id_transaksi }})" style="margin-left: 10px; font-size:13px" class="btn btn-sm btn-success"><i class="demo-pli-printer"></i></button>
                        </div> 
                    </div>													 --}}
                </td>
            </tr>
            @endforeach
            
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="font-size: 13px;">Grand Total</td>
                <td style="text-align: center; font-size: 13px;">{{ number_format($totalBayar, 0, ',', '.') }}</td>
                <td style="text-align: center; font-size: 13px;">{{ number_format($totalKembalian, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        
    </table>
    
    {{-- <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{ $dataTransaksi->appends(['ket_makanan' => request('ket_makanan'), 'start_date' => request('start_date'), 'end_date' => request('end_date')])->links('pagination::bootstrap-4') }}
        </ul>
    </nav> --}}
    
</div>
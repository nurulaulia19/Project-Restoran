{{-- bener --}}

@extends('layoutsAdmin.main')
@section('content')
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
		@if (session('activated'))
                        <div class="alert alert-success" role="alert">
                            {{ session('activated') }}
                        </div>
                    @endif
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-head">         
					<div class="pad-all text-center">
						<h3>Welcome back to the Dashboard.</h3>
						<p>This is your experience to manage the Resto Application.</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
					        <div class="col-xs-12">
					            <div class="panel">
					                <div class="panel-heading">
					                    <h3 class="panel-title">Laporan Transaksi</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													{{-- <a href="{{ route('transaksi.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a> --}}
													
					                            </div>
                                                    <form action="{{ route('laporan.laporanTransaksi') }}" method="get">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="start_date">Tanggal Awal: </label>
                                                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ session('start_date') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="end_date">Tanggal Akhir: </label>
                                                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ session('end_date') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="control-label">Status: </label>
                                                                    <select class="form-control" name="ket_makanan" id="ket_makanan">
                                                                        <option value=""{{ request('ket_makanan') === '' ? ' selected' : '' }}>Semua</option>
                                                                        <option value="dine in"{{ request('ket_makanan') === 'dine in' ? ' selected' : '' }}>Dine In</option>
                                                                        <option value="take away"{{ request('ket_makanan') === 'take away' ? ' selected' : '' }}>Take Away</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="submit" class="btn btn-primary" style="margin-right: 10px">Filter</button>
                                                                <a href="{{ route('export.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'ket_makanan' => request('ket_makanan')]) }}" class="btn btn-danger"  style="margin-right: 10px;">Export to PDF</a>
                                                                
                                                                <a href="{{ route('export.excel', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'ket_makanan' => request('ket_makanan')]) }}" class="btn btn-success">Export to Excel</a>

                                                                {{-- <div class="form-group">
                                                                    <label for="export_type">Eksport ke:</label>
                                                                    <select class="form-control" name="export_type" id="export_type">
                                                                        <option value="pdf">PDF</option>
                                                                        <option value="excel">Excel</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger" onclick="handleExport()">Eksport</button> --}}
                                                                {{-- <form action="{{ route('laporan.eksport') }}" method="post" id="exportForm">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger">Eksport</button>
                                                                </form> --}}
                                                                {{-- <form action="" method="post" id="exportForm">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="export_type">Eksport ke:</label>
                                                                        <select class="form-control" name="export_type" id="export_type">
                                                                            <option value="pdf">PDF</option>
                                                                            <option value="excel">Excel</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary" onclick="handleExport()">Eksport</button>

                                                                </form> --}}
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </form>
					                        </div>
					                    </div>
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
														<td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_harga, 2, ',', '.') }}</td>
                                                        <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_bayar, 2, ',', '.') }}</td>
                                                        <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_kembalian, 2, ',', '.') }}</td>
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
                                                        <td style="text-align: center; font-size: 13px;">{{ number_format($totalBayar, 2, ',', '.') }}</td>
                                                        <td style="text-align: center; font-size: 13px;">{{ number_format($totalKembalian, 2, ',', '.') }}</td>
                                                    </tr>
                                                </tfoot>
                                                
					                        </table>
                                            
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-center">
                                                    {{ $dataTransaksi->appends(['ket_makanan' => request('ket_makanan'), 'start_date' => request('start_date'), 'end_date' => request('end_date')])->links('pagination::bootstrap-4') }}
                                                </ul>
                                            </nav>
                                            
					                    </div>

                                        
                                        {{-- {{ $dataTransaksi->links('pagination::bootstrap-4') }} --}}
                                        {{-- {{ $dataTransaksi->appends(['start_date' => session('start_date'), 'end_date' => session('end_date'), 'ket_makanan' => session('status')])->links('pagination::bootstrap-4') }} --}}
                                        

					                    <hr class="new-section-xs">
					                    
					                </div>
					                <!--===================================================-->
					                <!--End Data Table-->
					
					            </div>
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
					        </div>
					    </div>
					
					
					    
                </div>
                <!--===================================================-->
                <!--End page content-->

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->
        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection

<script>
    function confirmDelete(menuId) {
        if (confirm('Are you sure you want to delete this item?')) {
            document.getElementById('delete-form-' + menuId).submit();
        }
    }
</script>

<script>
    function printReceipt(id_transaksi) {
        var printWindow = window.open('{{ route('transaksi.resi', ['id_transaksi' => '__id_transaksi__']) }}'.replace('__id_transaksi__', id_transaksi), '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>

{{-- <script>
    function handleExport() {
        var exportType = document.getElementById('export_type').value;
        var form = document.createElement('form');
        form.action = "{{ route('laporan.eksport') }}";
        form.method = 'post';
        var csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = "{{ csrf_token() }}";
        var exportTypeField = document.createElement('input');
        exportTypeField.type = 'hidden';
        exportTypeField.name = 'export_type';
        exportTypeField.value = exportType;
        form.appendChild(csrfField);
        form.appendChild(exportTypeField);
        document.body.appendChild(form);
        form.submit();
    }
</script> --}}

{{-- <script>
    // Fungsi untuk menangani submit form
    function handleExport() {
        var form = document.getElementById('exportForm');
        var exportType = document.getElementById('export_type').value;

        // Set action form sesuai dengan tipe eksport yang dipilih
        form.action = "{{ route('transaksi.export') }}" + "/" + exportType;
        form.submit();
    }
</script> --}}



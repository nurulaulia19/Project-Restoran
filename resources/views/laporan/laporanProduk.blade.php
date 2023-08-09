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
					                    <h3 class="panel-title">Laporan Produk</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            {{-- <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('produk.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
													
					                            </div> --}}
                                                <form action="{{ route('laporan.laporanProduk') }}" method="get">
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
                                                            {{-- <input type="hidden" name="status" value="{{ session('status') ?? '' }}"> --}}
                                                            <button type="submit" class="btn btn-primary" style="margin-right: 10px">Filter</button>
                                                            <a href="{{ route('exportproduk.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'ket_makanan' => request('ket_makanan')]) }}" class="btn btn-danger"  style="margin-right: 10px;">Export to PDF</a>
                                                            {{-- <button onclick="printReceipt({{ $item->id_transaksi }})" style="margin-left: 10px; font-size:13px" class="btn btn-sm btn-success"><i class="demo-pli-printer"></i></button> --}}
                                                            <a href="{{ route('exportproduk.excel', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'ket_makanan' => request('ket_makanan')]) }}" class="btn btn-success">Export to Excel</a>
                                                            {{-- Add the link to export to Excel --}}
                                                            {{-- <a href="{{ route('export.excel') }}" class="btn btn-success">Export to Excel</a> --}}
                                                        </div>
                                                    </div>
                                                </form>
                                                
					                           
					                        </div>
					                    </div>
					                    <div class="table-responsive">
                                            <table class="table table-striped">
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
                                        
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-center">
                                                    {{ $dataProduk->appends(['ket_makanan' => request('ket_makanan'), 'start_date' => request('start_date'), 'end_date' => request('end_date')])->links('pagination::bootstrap-4') }}
                                                </ul>
                                            </nav>
                                        </div>
                                        

                                        {{-- {{ $dataProduk->links('pagination::bootstrap-4') }} --}}
					                    <hr class="new-section-xs">
					                    {{-- <div class="pull-right">
					                        <ul class="pagination text-nowrap mar-no">
					                            <li class="page-pre disabled">
					                                <a href="#">&lt;</a>
					                            </li>
					                            <li class="page-number active">
					                                <span>1</span>
					                            </li>
					                            <li class="page-number">
					                                <a href="#">2</a>
					                            </li>
					                            <li class="page-number">
					                                <a href="#">3</a>
					                            </li>
					                            <li>
					                                <span>...</span>
					                            </li>
					                            <li class="page-number">
					                                <a href="#">9</a>
					                            </li>
					                            <li class="page-next">
					                                <a href="#">&gt;</a>
					                            </li>
					                        </ul>
					                    </div> --}}
					                </div>
					                <!--===================================================-->
					                <!--End Data Table-->
					
					            </div>
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

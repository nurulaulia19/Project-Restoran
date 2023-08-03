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
						<p>Scroll down to see quick links and overviews of your Server, To do list, Order status or get some Help using Nifty.</p>
					</div>
                    </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
					        <div class="col-xs-12">
					            <div class="panel">
					                <div class="panel-heading">
					                    <h3 class="panel-title">Data Transaksi</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('transaksi.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
													
					                            </div>
					                            <div class="col-sm-6 table-toolbar-right">
					                                <div class="form-group">
					                                    <input type="text" autocomplete="off" class="form-control" placeholder="Search" id="demo-input-search2">
					                                </div>
					                                <div class="btn-group">
					                                    <button class="btn btn-default"><i class="demo-pli-download-from-cloud icon-lg"></i></button>
					                                    <div class="btn-group dropdown">
					                                        <button class="btn btn-default btn-active-primary dropdown-toggle" data-toggle="dropdown">
					                                        <i class="demo-pli-dot-vertical icon-lg"></i>
					                                    </button>
					                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
					                                            <li><a href="#">Action</a></li>
					                                            <li><a href="#">Another action</a></li>
					                                            <li><a href="#">Something else here</a></li>
					                                            <li class="divider"></li>
					                                            <li><a href="#">Separated link</a></li>
					                                        </ul>
					                                    </div>
					                                </div>
					                            </div>
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
					                                    {{-- <td style="vertical-align: middle;">{{ $item->user_password }}</td> --}}
					                                    <td style="vertical-align: middle;">{{ $item->user->user_name }}</td>                                                      
														<td style="vertical-align: middle; text-align: center;">{{ $item->no_meja }}</td>
                                                        <td style="vertical-align: middle;">{{ $item->ket_makanan }}</td>
                                                        <td style="vertical-align: middle; text-align: center;">{{ $item->diskon_transaksi }} %</td>
														<td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                                        <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                                        <td style="vertical-align: middle; text-align: center;">{{ number_format($item->total_kembalian, 0, ',', '.') }}</td>
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center; justify-content:">
                                                                <a style="margin-right: 10px;" href="{{ route( 'transaksi.edit', $item->id_transaksi) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                <a href="{{ route( 'transaksi.destroy', $item->id_transaksi) }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_transaksi }})">Hapus</a>
															{{-- <form method="POST" action="" id="delete-form-{{ $item->id_transaksi }}" >
																@csrf
                												@method('DELETE')
																<a href="/admin/transaksi/destroy/{{ $item->id_transaksi }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_transaksi }})">Hapus</a>				
															</form>	 --}}
                                                            <div class="resi-container">
                                                                <button onclick="printReceipt({{ $item->id_transaksi }})" style="margin-left: 10px; font-size:13px" class="btn btn-sm btn-success"><i class="demo-pli-printer"></i></button>
                                                               
                                                            </div> 
                                                            </div>													
														</td>
					                                </tr>
													@endforeach
													
									
					                            </tbody>
					                        </table>
					                    </div>

                                        {{-- paging --}}

                                        {{-- {{ $dataTransaksi->links() }} --}}

                                        {{-- <div class="paging-container">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <!-- Tombol previous -->
                                                    <li class="page-item {{ $dataTransaksi->onFirstPage() ? 'disabled' : '' }}" id="btn-previous">
                                                        <a class="page-link" href="{{ $dataTransaksi->previousPageUrl() }}" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <!-- Tombol-tombol halaman -->
                                                    @foreach ($dataTransaksi as $page)
                                                        <li class="page-item {{ $page->isActivePage() ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $page->url }}">{{ $page->page }}</a>
                                                        </li>
                                                    @endforeach
                                                    <!-- Tombol next -->
                                                    <li class="page-item {{ $dataTransaksi->hasMorePages() ? '' : 'disabled' }}" id="btn-next">
                                                        <a class="page-link" href="{{ $dataTransaksi->nextPageUrl() }}" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div> --}}
                                        
                                        
                                        
                                        
                                        
                                        
                                        

                                        {{-- <div class="paging-container">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <!-- Tombol previous -->
                                                    <li class="page-item disabled" id="btn-previous">
                                                        <a class="page-link" href="#" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <!-- Tombol-tombol halaman -->
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <!-- Tombol next -->
                                                    <li class="page-item" id="btn-next">
                                                        <a class="page-link" href="#" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div> --}}
                                        
                                       
                                        
                                        
                                        
                                        
                                        
                                        

                                        {{-- akhir paging --}}

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

			<!--ASIDE-->
            <!--===================================================-->
            <aside id="aside-container">
                <div id="aside">
                    <div class="nano">
                        <div class="nano-content">
                            
                            <!--Nav tabs-->
                            <!--================================-->
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#demo-asd-tab-1" data-toggle="tab">
                                        <i class="demo-pli-speech-bubble-7 icon-lg"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#demo-asd-tab-2" data-toggle="tab">
                                        <i class="demo-pli-information icon-lg icon-fw"></i> Report
                                    </a>
                                </li>
                                <li>
                                    <a href="#demo-asd-tab-3" data-toggle="tab">
                                        <i class="demo-pli-wrench icon-lg icon-fw"></i> Settings
                                    </a>
                                </li>
                            </ul>
                            <!--================================-->
                            <!--End nav tabs-->



                            <!-- Tabs Content -->
                            <!--================================-->
                            <div class="tab-content">

                                <!--First tab (Contact list)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="tab-pane fade in active" id="demo-asd-tab-1">
                                    <p class="pad-all text-main text-sm text-uppercase text-bold">
                                        <span class="pull-right badge badge-warning">3</span> Family
                                    </p>

                                    <!--Family-->
                                    <div class="list-group bg-trans">
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/2.png') }}" alt="Profile Picture">
												<i class="badge badge-success badge-stat badge-icon pull-left"></i>
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Stephen Tran</p>
							                    <small class="text-muteds">Availabe</small>
							                </div>
							            </a>
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/7.png') }}" alt="Profile Picture">
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Brittany Meyer</p>
							                    <small class="text-muteds">I think so</small>
							                </div>
							            </a>
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/1.png') }}" alt="Profile Picture">
												<i class="badge badge-info badge-stat badge-icon pull-left"></i>
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Jack George</p>
							                    <small class="text-muteds">Last Seen 2 hours ago</small>
							                </div>
							            </a>
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/4.png') }}" alt="Profile Picture">
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Donald Brown</p>
							                    <small class="text-muteds">Lorem ipsum dolor sit amet.</small>
							                </div>
							            </a>
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/8.png') }}" alt="Profile Picture">
												<i class="badge badge-warning badge-stat badge-icon pull-left"></i>
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Betty Murphy</p>
							                    <small class="text-muteds">Idle</small>
							                </div>
							            </a>
							            <a href="#" class="list-group-item">
							                <div class="media-left pos-rel">
							                    <img class="img-circle img-xs" src="{{ asset('assets/img/profile-photos/9.png') }}" alt="Profile Picture">
												<i class="badge badge-danger badge-stat badge-icon pull-left"></i>
							                </div>
							                <div class="media-body">
							                    <p class="mar-no text-main">Samantha Reid</p>
							                    <small class="text-muteds">Offline</small>
							                </div>
							            </a>
                                    </div>

                                    <hr>
                                    <p class="pad-all text-main text-sm text-uppercase text-bold">
                                        <span class="pull-right badge badge-success">Offline</span> Friends
                                    </p>

                                    <!--Works-->
                                    <div class="list-group bg-trans">
                                        <a href="#" class="list-group-item">
                                            <span class="badge badge-purple badge-icon badge-fw pull-left"></span> Joey K. Greyson
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge badge-info badge-icon badge-fw pull-left"></span> Andrea Branden
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge badge-success badge-icon badge-fw pull-left"></span> Johny Juan
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge badge-danger badge-icon badge-fw pull-left"></span> Susan Sun
                                        </a>
                                    </div>


                                    <hr>
                                    <p class="pad-all text-main text-sm text-uppercase text-bold">News</p>

                                    <div class="pad-hor">
                                        <p>Lorem ipsum dolor sit amet, consectetuer
                                            <a data-title="45%" class="add-tooltip text-semibold text-main" href="#">adipiscing elit</a>, sed diam nonummy nibh. Lorem ipsum dolor sit amet.
                                        </p>
                                        <small><em>Last Update : Des 12, 2014</em></small>
                                    </div>


                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--End first tab (Contact list)-->


                                <!--Second tab (Custom layout)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="tab-pane fade" id="demo-asd-tab-2">

                                    <!--Monthly billing-->
                                    <div class="pad-all">
                                        <p class="pad-ver text-main text-sm text-uppercase text-bold">Billing &amp; reports</p>
                                        <p>Get <strong class="text-main">$5.00</strong> off your next bill by making sure your full payment reaches us before August 5, 2018.</p>
                                    </div>
                                    <hr class="new-section-xs">
                                    <div class="pad-all">
                                        <span class="pad-ver text-main text-sm text-uppercase text-bold">Amount Due On</span>
                                        <p class="text-sm">August 17, 2018</p>
                                        <p class="text-2x text-thin text-main">$83.09</p>
                                        <button class="btn btn-block btn-success mar-top">Pay Now</button>
                                    </div>


                                    <hr>

                                    <p class="pad-all text-main text-sm text-uppercase text-bold">Additional Actions</p>

                                    <!--Simple Menu-->
                                    <div class="list-group bg-trans">
                                        <a href="#" class="list-group-item"><i class="demo-pli-information icon-lg icon-fw"></i> Service Information</a>
                                        <a href="#" class="list-group-item"><i class="demo-pli-mine icon-lg icon-fw"></i> Usage Profile</a>
                                        <a href="#" class="list-group-item"><span class="label label-info pull-right">New</span><i class="demo-pli-credit-card-2 icon-lg icon-fw"></i> Payment Options</a>
                                        <a href="#" class="list-group-item"><i class="demo-pli-support icon-lg icon-fw"></i> Message Center</a>
                                    </div>


                                    <hr>

                                    <div class="text-center">
                                        <div><i class="demo-pli-old-telephone icon-3x"></i></div>
                                        Questions?
                                        <p class="text-lg text-semibold text-main"> (415) 234-53454 </p>
                                        <small><em>We are here 24/7</em></small>
                                    </div>
                                </div>
                                <!--End second tab (Custom layout)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


                                <!--Third tab (Settings)-->
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <div class="tab-pane fade" id="demo-asd-tab-3">
                                    <ul class="list-group bg-trans">
                                        <li class="pad-top list-header">
                                            <p class="text-main text-sm text-uppercase text-bold mar-no">Account Settings</p>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-1" type="checkbox" checked>
                                                <label for="demo-switch-1"></label>
                                            </div>
                                            <p class="mar-no text-main">Show my personal status</p>
                                            <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-2" type="checkbox" checked>
                                                <label for="demo-switch-2"></label>
                                            </div>
                                            <p class="mar-no text-main">Show offline contact</p>
                                            <small class="text-muted">Aenean commodo ligula eget dolor. Aenean massa.</small>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-3" type="checkbox">
                                                <label for="demo-switch-3"></label>
                                            </div>
                                            <p class="mar-no text-main">Invisible mode </p>
                                            <small class="text-muted">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </small>
                                        </li>
                                    </ul>


                                    <hr>

                                    <ul class="list-group pad-btm bg-trans">
                                        <li class="list-header"><p class="text-main text-sm text-uppercase text-bold mar-no">Public Settings</p></li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-4" type="checkbox" checked>
                                                <label for="demo-switch-4"></label>
                                            </div>
                                            Online status
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-5" type="checkbox" checked>
                                                <label for="demo-switch-5"></label>
                                            </div>
                                            Show offline contact
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pull-right">
                                                <input class="toggle-switch" id="demo-switch-6" type="checkbox" checked>
                                                <label for="demo-switch-6"></label>
                                            </div>
                                            Show my device icon
                                        </li>
                                    </ul>



                                    <hr>

                                    <p class="pad-hor text-main text-sm text-uppercase text-bold mar-no">Task Progress</p>
                                    <div class="pad-all">
                                        <p class="text-main">Upgrade Progress</p>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar progress-bar-success" style="width: 15%;"><span class="sr-only">15%</span></div>
                                        </div>
                                        <small>15% Completed</small>
                                    </div>
                                    <div class="pad-hor">
                                        <p class="text-main">Database</p>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar progress-bar-danger" style="width: 75%;"><span class="sr-only">75%</span></div>
                                        </div>
                                        <small>17/23 Database</small>
                                    </div>

                                </div>
                                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                <!--Third tab (Settings)-->

                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <!--===================================================-->
            <!--END ASIDE-->
            
            <!--MAIN NAVIGATION-->
            <!--===================================================-->
           
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->

       


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
    $(document).ready(function() {
        // Inisialisasi DataTables dengan opsi paging
        const dataTable = $('#data-table').DataTable({
            // Atur paging, misalnya 10 baris per halaman
            pageLength: 10,
        });

        // Atur tampilan halaman saat tabel di-render
        dataTable.on('draw', function() {
            const pageInfo = dataTable.page.info();
            const btnPrevious = $('#btn-previous');
            const btnNext = $('#btn-next');

            // Aktifkan atau nonaktifkan tombol previous berdasarkan halaman saat ini
            if (pageInfo.page === 0) {
                btnPrevious.addClass('disabled');
            } else {
                btnPrevious.removeClass('disabled');
            }

            // Aktifkan atau nonaktifkan tombol next berdasarkan halaman saat ini
            if (pageInfo.page === pageInfo.pages - 1) {
                btnNext.addClass('disabled');
            } else {
                btnNext.removeClass('disabled');
            }
        });

        // Saat tombol previous diklik, navigasi ke halaman sebelumnya
        $('#btn-previous').on('click', function() {
            dataTable.page('previous').draw('page');
        });

        // Saat tombol next diklik, navigasi ke halaman berikutnya
        $('#btn-next').on('click', function() {
            dataTable.page('next').draw('page');
        });
    });
</script> --}}

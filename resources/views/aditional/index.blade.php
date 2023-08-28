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
					                    <h3 class="panel-title">Aditional Produk</h3>
					                </div>
					
					                <!--Data Table-->
					                <!--===================================================-->
					                <div class="panel-body">
					                    <div class="pad-btm form-inline">
					                        <div class="row">
					                            <div class="col-sm-6 table-toolbar-left">
													<a href="{{ route('aditional.create') }}" class="btn btn-purple">
														<i class="demo-pli-add icon-fw"></i>Add
													</a>
													
					                            </div>
					                          
					                        </div>
					                    </div>
					                    <div class="table-responsive">
					                        <table class="table table-striped">
					                            <thead>
					                                <tr>
					                                    <th>No</th>
					                                    <th>Produk</th>
                                                        <th>Nama Aditional</th>
                                                        <th>Harga Aditional</th>
					                                </tr>
					                            </thead>
					                            <tbody>
													
													@foreach ($dataAditional as $item)
					                                <tr>
                                                        <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
					                                    <td style="vertical-align: middle;">
                                                            @if ($item->produk)
                                                                {{ $item->produk->nama_produk }}
                                                            @else
                                                                Produk not assigned
                                                            @endif 
                                                            
                                                        </td>
					                                    <td style="vertical-align: middle;">{{ $item->nama_aditional }}</td>
                                                        <td style="vertical-align: middle;">{{ number_format($item->harga_aditional, 2, ',', '.') }}</td>
														<td class="table-action" style="vertical-align: middle;">
                                                            <div style="display:flex; align-items:center">
                                                                <a style="margin-right: 10px;" href="{{ route( 'aditional.edit', $item->id_aditional) }}" class="btn btn-sm btn-warning">Edit</a>
															<form method="POST" action="" id="delete-form-{{ $item->id_aditional }}">
																@csrf
                												@method('DELETE')
																<a href="/admin/aditional/destroy/{{ $item->id_aditional }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_kategori }})">Hapus</a>				
															</form>	
                                                            </div>													
														</td>
					                                </tr>
													@endforeach
													<script>
														function confirmDelete(menuId) {
															if (confirm('Are you sure you want to delete this item?')) {
																document.getElementById('delete-form-' + menuId).submit();
															}
														}
													</script>
									
					                            </tbody>
					                        </table>
					                    </div>
                                        {{ $dataAditional->links('pagination::bootstrap-4') }}
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

                                @if(session('success'))
                                    <div class="alert alert-info">
                                        {{ session('success') }}
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

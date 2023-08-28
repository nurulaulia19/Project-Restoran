

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
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tambah Aditional Produk</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                               
                                <form method="POST" action="/aditional/store" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_produk">Nama Produk</label>
                                            <div class="col-sm-9">
                                                <select name="id_produk" id="id_produk" class="form-control">
                                                    <option disabled selected>Pilih Produk</option>
                                                    @foreach ($dataProduk as $item)
                                                        <option value="{{ $item->id_produk }}">{{ $item->nama_produk }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="produkError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_aditional">Nama Aditional</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Produk" name="nama_aditional" id="nama_aditional" class="form-control">
                                                <span id="aditionalError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="harga_aditional">Harga Aditional</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="harga_aditional" id="harga_aditional" class="form-control @error('harga_aditional') is-invalid @enderror" value="0" min="0" step="1">
                                                <span id="hargaError" class="error-message"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('aditional.index') }}" class="btn btn-secondary">KEMBALI</a>
                                        <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </form>
                               
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                        
                            </div>
                        </div>
                        @if(session('error'))
						<div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
					    @endif 
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





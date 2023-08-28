

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
                                    <h3 class="panel-title">Edit User</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('produk.update', $dataProduk->id_produk) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="id_kategori">Kategori</label>
                                            <div class="col-sm-9">
                                                <select name="id_kategori" id="id_kategori" class="form-control">
                                                    @foreach ($dataKategori as $item)
                                                    {{-- <option value="{{ $item->role_id }}" {{ $item->role_id == $dataUser->role_id ? 'selected' : '' }}> --}}
                                                    <option value="{{ $item->id_kategori }}" {{ $item->id_kategori == $dataProduk->id_kategori ? 'selected' : '' }}>
                                                        {{ $item->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span id="kategoriError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="nama_produk">Nama Produk</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Produk" name="nama_produk" id="nama_produk" class="form-control" value="{{ $dataProduk->nama_produk }}">
                                                <span id="produkError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="harga_produk">Harga Produk</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="harga_produk" id="harga_produk" class="form-control @error('harga_produk') is-invalid @enderror" value="{{ $dataProduk->harga_produk }}">
                                                <span id="hargaError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="gambar_produk">Gambar Produk</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="gambar_produk" id="gambar_produk" class="form-control">
                                                <span id="gambarError" class="error-message"></span>
                                                @if ($dataProduk->gambar_produk)
                                                    <a href="{{ asset($dataProduk->gambar_produk) }}" target="_blank">
                                                        <img src="{{ asset('storage/photos/'.basename($dataProduk->gambar_produk)) }}" width="100px" alt="">
                                                    </a>
                                                @endif
                                                @if ($errors->has('gambar_produk'))
                                                        <span class="text-danger">{{ $errors->first('gambar_produk') }}</span>
                                                @endif
                                            </div>                                                  
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="diskon_produk">Diskon (%)</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="diskon_produk" id="diskon_produk" class="form-control @error('diskon_produk') is-invalid @enderror" value="{{ $dataProduk->diskon_produk }}" min="0" step="1">
                                                <span id="diskonError" class="error-message"></span>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
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

{{-- @section('style')
<style>
    @if ($menu->menu_category=="master menu")
    #hidden_div {
    display: none ;
}
@else
#hidden_div {
    display: block ;
}
    @endif
    
</style>
@endsection

@section('script')
<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 'sub menu' ? 'block' : 'none';
}
</script>

@endsection --}}

{{-- <?php
$userPhotoUrl = $dataUser->user_photo; 
?>

<script>
    var userPhotoUrl = "<?php echo $userPhotoUrl; ?>";
    if (userPhotoUrl) {
        var userPhotoInput = document.getElementById('user_photo');
        
        // Buat elemen option baru
        var option = document.createElement('option');
        option.value = userPhotoUrl;
        option.text = 'Existing Photo';
        option.selected = true; 

        while (userPhotoInput.firstChild) {
            userPhotoInput.firstChild.remove();
        }
        
        // Tambahkan opsi ke input file
        userPhotoInput.appendChild(option);
    }
</script> --}}







{{-- bener --}}

@extends('layoutsAdmin.main')
<link rel="stylesheet" href="{{ asset('assets-ui/style.css') }}">
  
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
{{-- 
					    <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tambah Transaksi</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/transaksi/store">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
					                            <div class="form-group">
					                                <label class="control-label">No Transaksi</label>
                                                    <input type="text" placeholder="No Transaksi" name="id_transaksi" id="id_transaksi" class="form-control">
					                            </div> 
					                        </div>
                                            <div class="col-sm-6">
					                            <div class="form-group">
					                                <label class="control-label">Tanggal</label>
                                                    <input type="date" placeholder="Tanggal" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control">
					                            </div>
					                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Id Customer</label>
                                                <input type="text" placeholder="Nama Customer" name="user_id" id="user_id" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">No Meja</label>
                                                <input type="text" placeholder="No Meja" name="no_meja" id="no_meja" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Status</label>
                                                <select class="form-control" name="ket_makanan" id="ket_makanan">
                                                    <option disabled selected>Pilih Status</option>
                                                    <option value="dine in">Dine In</option>
                                                    <option value="take away">Take Away</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->   

                            </div> --}}
                            
                            <div class="row">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Tambah Transaksi</h3>
                                    </div>

                                    
                                <div class="col-xs-6 scroll-container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label for="filterKategori">Filter Kategori:</label>
                                            <select class="form-control" id="filterKategori" name="filterKategori">
                                                <option disabled selected>Pilih Kategori</option>
                                                @foreach ($dataKategori as $item)
                                                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="searchInput">Search:</label>
                                                <input type="text" class="form-control" id="searchInput" placeholder="Cari produk...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        @foreach ($dataProduk as $index => $item)
                                          <div class="col-xs-2" style="margin: 20px; height: 250px;">
                                            <div class="card" >
                                               
                                                <a href="#" data-toggle="modal" data-target="#modal{{ $item->id_produk }}">
                                                    <img src="{{ asset('storage/photos/'.basename($item->gambar_produk)) }}" class="card-img-top" alt="..." style="height: 160px; width: 100px; cursor: pointer;">
                                                </a>
                                              {{-- <img src="{{ asset('storage/photos/'.basename($item->gambar_produk)) }}" class="card-img-top" alt="..." style="height: 160px; cursor: pointer;" data-target="modal{{ $item->id_produk }}"> --}}
                                              <div class="card-body" style="height: 92px; overflow: hidden;">
                                                <div class="product-info">
                                                    <p class="product-name">{{ $item->nama_produk }}</p>
                                                    <p class="product-price">{{ 'Rp ' . number_format($item->harga_produk, 0, ',', '.') }}</p>
                                                    @if($item->diskon_produk != 0)
                                                    <div class="discount-badge">
                                                        <p class="discount-text">Diskon {{ $item->diskon_produk }}%</p>
                                                    </div>
                                                    @endif
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          @if (($index + 1) % 4 === 0)
                                            <div class="w-100"></div> <!-- Gunakan class 'w-100' untuk membuat baris baru -->
                                        @endif
                                        @include('transaksi.modal')
                                        @endforeach

                                      </div>
                                </div>
                                <div class="col-xs-6">
                                    <div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 12px">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Produk</th>
                                                            <th class="min-tablet">QTY</th>
                                                            <th class="min-tablet">Diskon</th>
                                                            <th class="min-desktop">Harga</th>
                                                            <th class="min-desktop">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $totalSemuaHarga = 0; // Variabel untuk menyimpan total harga dari semua totalHargaSetelahDiskon
                                                        @endphp
                                                        @foreach ($dataTransaksiDetail as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->produk->nama_produk }} 
                                                                <div style="color:blue">
                                                                    @php
                                                                         $hargaAditional = 0; 
                                                                    @endphp
                                                                  
                                                                    @if ($item->transaksiDetailAditional)
                                                                    
                                                                    @foreach ($item->transaksiDetailAditional as $items)
                                                                        {{ $items->dataAditional->nama_aditional }} 
                                                                        @php
                                                                            $hargaAditional = $hargaAditional + $items->dataAditional->harga_aditional;
                                                                        @endphp
                                                                    @endforeach
                                                                @else
                                                                    N/A 
                                                                @endif
                                                                </div>
                                                                
                                                            </td> 
                                                            
                                                            <td style="text-align: center;">
                                                                <form action="{{ route('transaksidetail.update', ['id' => $item->id_transaksi_detail]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                                                                    <input type="number" name="jumlah_produk" value="{{ $item->jumlah_produk }}" min="1" step="1" class="jumlah-produk" onchange="updateTotalPrice(this, {{ $hargaAditional }})">
                                                                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                                                                </form>
                                                            </td>                                                      
                                                            <td style="text-align: right;" class="diskon-produk">
                                                                {{ $item->produk->diskon_produk }}%
                                                            </td>
                                                            {{-- <td style="text-align: right;">{{ number_format($item->produk->harga_produk, 0, ',', '.') }}</td> --}}
                                                            <td style="text-align: right;" class="harga-produk">
                                                                {{ number_format($item->produk->harga_produk, 0, ',', '.') }}
                                                            </td>
                                                            <td style="text-align: right;" class="total-harga-setelah-diskon">
                                                                @php
                                                                $hargaProduk = $item->produk->harga_produk;
                                                                $diskonProduk = $item->produk->diskon_produk; // Diskon produk dalam persen
                                                                $jumlahProduk = $item->jumlah_produk;
                                                                $totalHargaSebelumDiskon = $hargaProduk * $jumlahProduk;
                                                            
                                                                // Hitung total harga additional
                                                                $totalHargaAdditional = 0;
                                                                if ($item->transaksiDetailAditional) {
                                                                    foreach ($item->transaksiDetailAditional as $items) {
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
                                                            <td>
                                                                <form method="POST" action="" id="delete-form-{{ $item->id_transaksi_detail }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    {{-- <a href="/admin/produk/destroy/{{ $item->id_produk }}" --}}
                                                                    <a href="/admin/transaksidetail/destroy/{{ $item->id_transaksi_detail  }}" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_transaksi_detail }})">Hapus</a>				
                                                                </form>	
        
                                                            </td>
                                                        </tr>
                                                        @php
                                                        // Akumulasi total harga ke variabel $totalSemuaHarga
                                                        $totalSemuaHarga += $totalHargaSetelahDiskon;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" style="text-align: right;">Total Harga</td>
                                                            <td style="text-align: right;" class="overall-total">
                                                              {{ number_format($totalSemuaHarga, 0, ',', '.') }}
                                                            </td>
                                                          </tr>
                                                    </tfoot>

                                                   
                                                </table>
                                                <div class="panel-footer text-right">
                                                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">KEMBALI</a>
                                                    <button type="button" data-toggle="modal" data-target="#modalBayar" class="btn btn-primary">SIMPAN</button>
                                                </div>
                                            </div>
                                            @include('transaksi.modalBayar')
                                        </div>
                                        {{-- <form method="POST" action="/transaksi/store" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="panel-body">
                                                <div class="form-group d-flex mb-3">
                                                    <label class="col-sm-3 control-label" for="diskon_transaksi">Diskon</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" placeholder="Diskon" name="diskon_transaksi" id="diskon_transaksi" class="form-control">
                                                        <span id="diskon_transaksi_error" class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex mb-3">
                                                    <label class="col-sm-3 control-label" for="total_bayar">Total Harga</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" placeholder="Total Harga" name="total_harga" id="total_harga_input" class="form-control" value="{{ number_format($totalSemuaHarga, 0, ',', '.') }}">
                                                        <span id="total_harga_error" class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex mb-3">
                                                    <label class="col-sm-3 control-label" for="total_bayar">Total Bayar</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" placeholder="Total Bayar" name="total_bayar" id="total_bayar_input" class="form-control">
                                                        <span id="total_bayar_error" class="error-message"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex mb-3">
                                                    <label class="col-sm-3 control-label" for="total_kembalian">Total Kembalian</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" placeholder="Total Kembalian" name="total_kembalian" id="total_kembalian_input" class="form-control">
                                                        <span id="total_kembalian_error" class="error-message"></span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="panel-footer text-right">
                                                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">KEMBALI</a>
                                                <button type="submit" onclick="validateForm(event)" class="btn btn-primary">SIMPAN</button>
                                            </div>
                                        </form> --}}
                                        
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

        </div>


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



@section('script')

<script>
    // Function to calculate and update total harga based on diskon
    function updateTotalHarga() {
        const diskonInput = document.getElementById('diskon_transaksi');
        const totalHargaInput = document.getElementById('total_harga_input');

        const totalSemuaHarga = {{ $totalSemuaHarga }};
        const diskonValue = diskonInput.value.trim() === '' ? 0 : parseFloat(diskonInput.value);

        if (isNaN(diskonValue) || diskonValue < 0 || diskonValue > 100) {
            document.getElementById('diskon_transaksi_error').textContent = 'Diskon harus berada antara 0 dan 100.';
            totalHargaInput.value = '';
        } else {
            document.getElementById('diskon_transaksi_error').textContent = '';
            const totalHargaSetelahDiskon = totalSemuaHarga * (1 - diskonValue / 100);
            totalHargaInput.value = formatNumber(totalHargaSetelahDiskon);
        }
    }

    // Add event listener to diskon_transaksi input for real-time updates
    const diskonInput = document.getElementById('diskon_transaksi');
    diskonInput.addEventListener('input', updateTotalHarga);

    // Function to format number with thousand separators
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(number);
    }
</script>

<script>
    // Function to calculate and update total kembalian based on total bayar
    function updateTotalKembalian() {
        const totalBayarInput = document.getElementById('total_bayar_input');
        const totalKembalianInput = document.getElementById('total_kembalian_input');

        const totalSemuaHarga = parseFloat(document.getElementById('total_harga_input').value.replace(/\./g, '').replace(',', '.'));
        const totalBayarValue = parseFloat(totalBayarInput.value.trim());

        if (isNaN(totalBayarValue) || totalBayarValue < 0) {
            document.getElementById('total_bayar_error').textContent = 'Total Bayar harus angka positif.';
            totalKembalianInput.value = '';
        } else {
            document.getElementById('total_bayar_error').textContent = '';
            const totalKembalian = totalBayarValue - totalSemuaHarga;
            totalKembalianInput.value = formatNumber(totalKembalian);
        }
    }

    // Add event listener to total_bayar input for real-time updates
    const totalBayarInput = document.getElementById('total_bayar_input');
    totalBayarInput.addEventListener('input', updateTotalKembalian);

    // Function to format number with thousand separators
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(number);
    }

</script>

<script>
    // Function to handle form validation and show the modal
    function validateForm(event) {
      event.preventDefault(); // Prevent the default form submission behavior
  
      // Add your form validation logic here if needed
      // ...
  
      // Show the modal
      const modalBayar = document.getElementById('modalBayar');
      modalBayar.style.display = 'block';
  
      // You might need additional logic here, depending on how your modal works (e.g., handling close button or backdrop click)
    }
  </script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Listen to changes in the filterKategori and searchInput
    $('#filterKategori, #searchInput').on('change input', function () {
        var selectedCategoryId = $('#filterKategori').val();
        var searchValue = $('#searchInput').val().toLowerCase();

        $('.produk-item').each(function () {
            var itemKategori = $(this).data('kategori');
            var itemText = $(this).text().toLowerCase();
            var isCategoryMatch = selectedCategoryId === '' || selectedCategoryId == itemKategori;
            var isSearchMatch = itemText.includes(searchValue);

            // Show the product if it matches the selected category and search input, hide otherwise
            $(this).toggle(isCategoryMatch && isSearchMatch);
        });
    });
</script>

@endsection






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
						<p>This is your experience to manage the Resto Application.</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                            
                            <div class="row">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Edit Transaksi</h3>
                                    </div>
                                    <div class="col-xs-6 scroll-container">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <form action="{{ route('transaksi.filter', ['id_transaksi' => $dataTransaksi->id_transaksi]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="filterKategori">Filter Kategori:</label>
                                                        <select class="form-control" id="filterKategori" name="selectedKategori" onchange="this.form.submit()">
                                                            <option value="">Semua Kategori</option>
                                                            @foreach ($dataKategori as $item)
                                                                <option value="{{ $item->id_kategori }}" {{ $item->id_kategori == $selectedKategoriId ? 'selected' : '' }}>
                                                                    {{ $item->nama_kategori }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            </div> 
                                            <div class="col-sm-6">
                                                <form action="{{ route('produk.searchEdit', ['id_transaksi' => $dataTransaksi->id_transaksi]) }}" method="POST" class="form-inline">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="searchInput">Cari produk berdasarkan nama:</label>
                                                        <input type="text" class="form-control" id="searchInput" name="keyword" placeholder="Masukkan nama produk...">
                                                        <button type="submit" class="btn btn-primary ml-2">Cari</button>
                                                    </div>
                                                    <input type="hidden" name="selectedKategori" value="{{ $selectedKategoriId }}">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row" id="produkContainer">
                                            
                                            @foreach ($dataProduk as $index => $item)
                                              <div class="col-xs-2" style="margin: 20px; height: 250px;" data-nama="{{ strtolower($item->nama_produk) }}" data-kategori="{{ $item->id_kategori }}">
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
                                            @include('transaksi.modalBayarEdit')
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
                                                @php
                                                    $totalHargaDiskon = $totalSemuaHarga * $dataTransaksi->diskon_transaksi / 100;
                                                @endphp
                                                <div class="panel-footer text-right">
                                                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">KEMBALI</a>
                                                    <button type="button" data-toggle="modal" data-target="#modalEdit" class="btn btn-primary">SIMPAN</button>
                                                </div>
                                            </div>
                                            @include('transaksi.modalEdit')
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(session('error'))
						<div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
					    @endif
					
                    
                <!--===================================================-->
                <!--End page content-->

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


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
        const totalBayarInput = document.getElementById('total_bayar_input');
        const totalKembalianInput = document.getElementById('total_kembalian_input');

        const totalSemuaHarga = {{ $totalSemuaHarga}};
        const diskonValue = diskonInput.value.trim() === '' ? 0 : parseFloat(diskonInput.value);
        const totalBayarValue = parseFloat(totalBayarInput.value.trim());

        if (isNaN(diskonValue) || diskonValue < 0 || diskonValue > 100) {
            document.getElementById('diskon_transaksi_error').textContent = 'Diskon harus berada antara 0 dan 100.';
            totalHargaInput.value = '';
        } else {
            document.getElementById('diskon_transaksi_error').textContent = '';
            const totalHargaSetelahDiskon = totalSemuaHarga * (1 - diskonValue / 100);
            totalHargaInput.value = formatNumber(totalHargaSetelahDiskon);

            if (!isNaN(totalBayarValue) && totalBayarValue >= totalHargaSetelahDiskon) {
                const totalKembalian = totalBayarValue - totalHargaSetelahDiskon;
                totalKembalianInput.value = formatNumber(totalKembalian);
            } else {
                totalKembalianInput.value = '';
            }
        }
    }
    
    // Add event listeners to diskon_transaksi and total_bayar inputs for real-time updates
    const diskonInput = document.getElementById('diskon_transaksi');
    diskonInput.addEventListener('input', updateTotalHarga);

    const totalBayarInput = document.getElementById('total_bayar_input');
    totalBayarInput.addEventListener('input', updateTotalHarga);

    // Function to format number with thousand separators
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(number);
    }

    // Initial update when the page loads
    updateTotalHarga();
</script>

<script>
    // Function to handle form validation and show the modal
    function validateForm(event) {
      event.preventDefault(); // Prevent the default form submission behavior
  
      // Add your form validation logic here if needed
      // ...
  
      // Show the modal
      const modalEdit = document.getElementById('modalEdit');
      modalEdit.style.display = 'block';
  
      // You might need additional logic here, depending on how your modal works (e.g., handling close button or backdrop click)
    }
  </script>
  
  <script>
    function searchProducts() {
        // Ambil nilai kata kunci dari input pencarian
        var keyword = document.getElementById('searchInput').value.toLowerCase();
        
        // Ambil semua produk yang ditampilkan
        var produkContainer = document.getElementById('produkContainer');
        var produkItems = produkContainer.getElementsByClassName('produk-item');

        // Loop melalui setiap produk dan sembunyikan/munculkan sesuai dengan kata kunci
        for (var i = 0; i < produkItems.length; i++) {
            var namaProduk = produkItems[i].getAttribute('data-nama').toLowerCase();

            // Jika kata kunci ditemukan dalam nama produk, tampilkan; jika tidak, sembunyikan
            if (namaProduk.includes(keyword)) {
                produkItems[i].style.display = "block";
            } else {
                produkItems[i].style.display = "none";
            }
        }
    }
</script>

<script>
    function filterByCategory() {
        var selectedKategoriId = document.getElementById('filterKategori').value;
        var produkContainer = document.getElementById('produkContainer');
        var produkItems = produkContainer.getElementsByClassName('produk-item');

        for (var i = 0; i < produkItems.length; i++) {
            var produkKategoriId = produkItems[i].getAttribute('data-kategori');

            if (selectedKategoriId === '' || produkKategoriId === selectedKategoriId) {
                produkItems[i].style.display = "block";
            } else {
                produkItems[i].style.display = "none";
            }
        }
    }
</script>

<script>
    function submitForm() {
        const filterKategori = document.getElementById('filterKategori');
        const selectedKategoriId = filterKategori.value;
        const form = filterKategori.closest('form');

        // Remove any existing hidden input for filterKategori (if present)
        const existingInput = document.querySelector('input[name="filterKategori"]');
        if (existingInput) {
            existingInput.remove();
        }

        // Append the selected category ID as a hidden input to the form
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'filterKategori';
        hiddenInput.value = selectedKategoriId;
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>   

@endsection




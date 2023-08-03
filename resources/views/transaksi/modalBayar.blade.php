<div class="modal fade" id="modalBayar" tabindex="-1" role="dialog" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBayarLabel">Bayar Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('transaksi.storeTransaksi') }}" id="transaksiForm">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" placeholder="Tanggal" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control">
                                    <span id="tanggal_transaksiError" class="error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nama Kasir</label>
                                    <input type="text" name="user_name" value="{{ auth()->user()->user_name }}" class="form-control" readonly>
                                    <span id="user_nameiError" class="error-message"></span>
                                </div>   
                            </div>
                        </div>
                    <div class="row">
                            
                      
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama Kasir</label>
                                <input type="text" placeholder="Nama Kasir" name="user_id" id="user_id" class="form-control">
                            </div>
                        </div> --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">No Meja</label>
                                <input type="text" placeholder="No Meja" name="no_meja" id="no_meja" class="form-control">
                                <span id="no_meja_error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Status</label>
                              <select class="form-control" name="ket_makanan" id="ket_makanan">
                                <option disabled selected>Pilih Status</option>
                                <option value="dine in">Dine In</option>
                                <option value="take away">Take Away</option>
                              </select>
                            </div>
                            <div id="status_error" style="color: red; display: none;">Kolom status harus diisi.</div>
                            {{-- @error('ket_makanan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                            {{-- <span id="status_warning" style="color: red;"></span> --}}
                        </div>
                    </div>
                    <hr>
                    <div class="form-group d-flex mb-3">
                        <label class="col-sm-3 control-label" for="diskon_transaksi">Diskon</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Diskon" name="diskon_transaksi" id="diskon_transaksi" class="form-control" onblur="setDefaultDiskon()">
                        </div>
                    </div>
                    <div class="form-group d-flex mb-3">
                        <label class="col-sm-3 control-label" for="total_bayar">Total Harga</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Total Harga" name="total_harga" id="total_harga_input" class="form-control" value="{{ number_format($totalSemuaHarga, 0, ',', '.') }}">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    // Mendapatkan elemen input tanggal
    var inputTanggal = document.getElementById('tanggal_transaksi');

    // Mendapatkan tanggal sekarang
    var today = new Date();
    var year = today.getFullYear();
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0, tambahkan 1 dan pad dengan 0 jika hanya satu digit
    var day = String(today.getDate()).padStart(2, '0');

    // Format tanggal sesuai dengan input tanggal (yyyy-mm-dd)
    var formattedDate = year + '-' + month + '-' + day;

    // Set nilai default input tanggal
    inputTanggal.value = formattedDate;
</script>


<script>
    function setDefaultDiskon() {
        var diskonInput = document.getElementById('diskon_transaksi');
        if (diskonInput.value.trim() === '') {
            diskonInput.value = '0';
        }
    }
</script>

<script>
    document.getElementById('transaksiForm').addEventListener('submit', function (event) {
        var ketMakananInput = document.getElementById('ket_makanan');
        var statusErrorDiv = document.getElementById('status_error');

        if (ketMakananInput.value === "") {
            statusErrorDiv.style.display = 'block';
            event.preventDefault();
        } else {
            statusErrorDiv.style.display = 'none';
        }
    });
</script>



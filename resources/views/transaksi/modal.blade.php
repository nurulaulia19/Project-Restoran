 @foreach ($dataProduk as $item)
  <!-- ... Kode lainnya ... -->
  <div class="modal" id="modal{{ $item->id_produk }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ $item->nama_produk }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group d-flex">
                    <div class="col-sm-12">
                         <div class="radio-container" style="display: flex; flex-direction: column;">
                                @foreach ($item->aditionalProduk as $items)
                                <div class="row">
					                <div class="col-xs-6">
                                        <input class="form-check-input" name="id_aditional[]" type="radio" value="{{ $items->id_aditional }}">
                                        <label class="form-check-label">{{ $items->nama_aditional }}</label>
                                    </div>
					                <div class="col-xs-6">
                                        <p>Harga: {{ $items->harga_aditional }}</p>
                                    </div>
					            </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ... Kode lainnya ... -->
@endforeach

<form role="form" method='POST' action="{{ url('setting/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Ketentuan Baptis</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
            <label style='color:red'>*Ketentuan Baptis</label>
            <div class="form-group">
                <label >Bayi & Anak: Umur kurang dari sama dengan (Tahun)</label>
                <input type="number" value="{{$data->umur_baptis}}" class="form-control" id='umur_baptis_bayii' name='umur_baptis_bayi' oninput='autoumurdewasaa()' min="1" required>
            </div>
            <div class="form-group">
                <label >Dewasa: Umur lebih dari sama dengan (Tahun)</label>
                <input type="number" value="{{$data->umur_baptis}}" class="form-control" id='umur_baptis_dewasaa' name='umur_baptis_dewasa' oninput='autoumurbayii()' min="1" required>
            </div>
            <label style='color:red'>*Lampiran yang disertakan (optional)</label>
            <div class="form-group">
                <label >Akta Kelahiran</label>
                <input type="checkbox" id="akta_kelahirann" name="akta_kelahiran">
                <br>
                <label >Kartu Keluarga</label>
                <input type="checkbox" id="kartu_keluargaa" name="kartu_keluarga">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
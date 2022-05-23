<form role="form" method='POST' action="{{ url('misas/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Reservasi Misa</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label >Jenis</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" class="form-control" id='jenis' name='jenis' placeholder="Jenis" value="{{$data->jenis}}" disabled>
            </div>
            <div class="form-group">
                <label >Jadwal</label>
                <input type="datetime-local" class="form-control" id='jadwal' name='jadwal' placeholder="Jadwal" value="{{$data->jadwal}}" disabled>
            </div>
            <div class="form-group">
                <label >Lokasi</label>
                <input type="text" class="form-control" id='lokasi' name='lokasi' placeholder="Lokasi" value="{{$data->lokasi}}" disabled>
            </div>
            <div class="form-group">
                <label >Kuota</label>
                <input type="text" class="form-control" id='kuota' name='kuota' placeholder="Kuota" value="{{$data->kuota}}" disabled>
            </div>
            <div class="form-group">
                <label >Jumlah Pemesanan Tiket</label>
                <input type="number" class="form-control" id='qty' name='qty' placeholder="1">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
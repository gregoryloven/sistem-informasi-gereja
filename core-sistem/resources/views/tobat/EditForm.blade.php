<form role="form" method='POST' action="{{ url('tobats/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Misa</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label >Jadwal</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="datetime-local" class="form-control" id='jadwal' name='jadwal' placeholder="Jadwal" value="{{$data->jadwal}}">
            </div>
            <div class="form-group">
                <label >Lokasi</label>
                <input type="text" class="form-control" id='lokasi' name='lokasi' placeholder="Lokasi" value="{{$data->lokasi}}">
            </div>
            <div class="form-group">
                <label >Kuota</label>
                <input type="text" class="form-control" id='kuota' name='kuota' placeholder="Kuota" value="{{$data->kuota}}">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
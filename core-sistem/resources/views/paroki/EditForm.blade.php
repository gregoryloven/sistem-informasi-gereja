<form role="form" method='POST' action="{{ url('parokis/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Paroki</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label >Nama</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" class="form-control" id='nama_paroki' name='nama_paroki' placeholder="Nama" value="{{$data->nama_paroki}}">
            </div>
            <div class="form-group">
                <label >Alamat</label>
                <input type="text" class="form-control" id='alamat' name='alamat' placeholder="Alamat" value="{{$data->alamat}}">
            </div>
            <div class="form-group">
                <label >Email</label>
                <input type="text" class="form-control" id='email' name='email' placeholder="Email" value="{{$data->email}}">
            </div>
            <div class="form-group">
                <label >Telepon</label>
                <input type="text" class="form-control" id='telepon' name='telepon' placeholder="Telepon" value="{{$data->telepon}}">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
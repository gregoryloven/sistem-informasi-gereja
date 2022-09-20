<form role="form" method='POST' action="{{ url('user/update/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Akun Ketua KBG</h4>
    </div>
    <div class="modal-body">
        @csrf

        <div class="form-body">
            <div class="form-group">
                <label >Email</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" class="form-control" id='email' name='email' placeholder="Email" value="{{$data->email}}">
            </div>
            <div class="form-group">
                <label >KBG</label>
                <select class="form-control" id='kbg_id' name='kbg_id'>
                    <option value="{{$data->Kbg->id}}">{{ $data->Kbg->nama_kbg }}</option>
                    @foreach($kbg as $k)
                    <option value="{{$k->id}}">{{ $k->nama_kbg }}</option>
                    @endforeach
                </select>
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
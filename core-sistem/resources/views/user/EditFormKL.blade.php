<form role="form" method='POST' action="{{ url('user/update/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Akun Ketua Lingkungan</h4>
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
                <select class="form-control" id='lingkungan_id' name='lingkungan_id'>
                    <option value="{{$data->Lingkungan->id}}">{{ $data->Lingkungan->nama_lingkungan }}</option>
                    @foreach($ling as $l)
                    <option value="{{$l->id}}">{{ $l->nama_lingkungan }}</option>
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
<form role="form" method='POST' action="{{ url('umat/UbahUmatKBG/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Data Umat</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label >Nama Lengkap</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" class="form-control" value="{{$data->nama_lengkap}}" id='nama_lengkap' name='nama_lengkap' placeholder="Nama Lengkap">
            </div>
            <label >Hubungan Darah</label>
                <select class="form-control" id='hubungan_darah' name='hubungan_darah' required>
                    <option value="{{$data->hubungan}}">{{$data->hubungan}}</option>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                </select>
            </div>
            <div class="form-group">
                <label >Jenis Kelamin</label>
                <select class="form-control" id='jenis_kelamin' name='jenis_kelamin' required>
                    <option value="{{$data->jenis_kelamin}}">{{$data->jenis_kelamin}}</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
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
            <div class="form-group">
                <label >Alamat</label>
                <input type="text" class="form-control" value="{{$data->alamat}}" id='alamat' name='alamat'>
            </div>
            <div class="form-group">
                <label >Telepon</label>
                <input type="text" class="form-control" value="{{$data->telepon}}" id='telepon' name='telepon'>
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
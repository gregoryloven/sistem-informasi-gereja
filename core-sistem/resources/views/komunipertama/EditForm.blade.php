<form role="form" method='POST' action="{{ url('komunipertamas/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Komuni Pertama</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
        <div class="form-group">
            <label >User</label>
            <select class="form-control" id='user_id' name='user_id'>
            <option value="">Choose</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->nama_user }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label >Romo</label>
            <select class="form-control" id='id_romo' name='id_romo'>
            <option value="">Choose</option>
            @foreach($romo as $r)
            <option value="{{ $r->id }}">{{ $r->nama_user }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label >Paroki</label>
            <select class="form-control" id='paroki_id' name='paroki_id'>
            <option value="">Choose</option>
            @foreach($paroki as $p)
            <option value="{{ $p->id }}">{{ $p->nama_paroki }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-body">
            <div class="form-group">
                <label >Tanggal Komuni Pertama</label>
                <input type="date" class="form-control" id='jadwal' name='jadwal' placeholder="Tanggal Komuni Pertama" required>
            </div>
        <div class="form-group">
            <label >Status</label>
            <select class="form-control" id='status' name='status'>
            <option value="">Choose</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
            </select>
        </div>
            <div class="form-group">
                <label>File Sertifikat</label>
                <input type="file" value="" name="file_sertifikat" class="form-control" id="file_sertifikat" placeholder="File Sertifikat" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
            </div>
            <img id="output" src="" width="200px" height="200px">
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
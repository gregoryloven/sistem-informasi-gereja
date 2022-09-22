<form role="form" method='POST' action="{{ url('listevent/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Event</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label >Nama</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" value="{{$data->nama_event}}" class="form-control" id='nama_eventt' name='nama_event' placeholder="Nama Event">
            </div>
            <div class="form-group">
                <label >Jenis Event</label>
                <select class="form-control" id='jenis_eventt' name='jenis_event' required disabled>
                    <option value="{{$data->jenis_event}}">{{$data->jenis_event}}</option>
                    <option value="Baptis Bayi">Baptis Bayi</option>
                    <option value="Baptis Dewasa">Baptis Dewasa</option>
                    <option value="Komuni Pertama">Komuni Pertama</option>
                    <option value="Krisma">Krisma</option>
                    <option value="Tobat">Tobat</option>
                    <option value="Misa">Misa</option>
                    <option value="Petugas Liturgi">Petugas Liturgi</option>
                </select>
            </div>
            <div class="form-group">
                <label >Tanggal Buka Pendaftaran</label>
                <input type="date" value="{{$data->tgl_buka_pendaftaran}}" class="form-control" id='tgl_buka_pendaftarann' name='tgl_buka_pendaftaran'  onchange='MinStartDatee(this)' min="<?= date('Y-m-d'); ?>" placeholder="Tanggal Buka Pendaftaran" required>
            </div>
            <div class="form-group">
                <label >Tanggal Tutup Pendaftaran</label>
                <input type="date" value="{{$data->tgl_tutup_pendaftaran}}" class="form-control" id='tgl_tutup_pendaftarann' name='tgl_tutup_pendaftaran'  onchange='CheckEndDatee(this)' placeholder="Tanggal Tutup Pendaftaran" required>
            </div>
            <div class="form-group">
                <label >Jadwal Pelaksanaan</label>
                <input type="datetime-local" value="{{$data->jadwal_pelaksanaan}}" class="form-control" id='jadwal_pelaksanaann' name='jadwal_pelaksanaan' onchange='CheckJadwalPelaksanaann(this)' placeholder="Jadwal Pelaksanaan" required>
            </div>
            <div class="form-group">
                <label >Lokasi</label>
                <input type="text" value="{{$data->lokasi}}" class="form-control" id='lokasii' name='lokasi' placeholder="Lokasi" required>
            </div>
            @if($data->jenis_event != 'Petugas Liturgi')
            <div class="form-group">
                <label >Romo</label>
                <input type="text" value="{{$data->romo}}" class="form-control" id='romoo' name='romo' placeholder="Romo" required>
            </div>
            @endif
            @if($data->jenis_event == 'Misa' || $data->jenis_event == 'Tobat')
            <div class="form-group">
                <label >Kuota</label>
                <input type="text" value="{{$data->kuota}}" class="form-control" id='kuotaa' name='kuotaa' placeholder="Kuota" required>
            </div>
            @endif
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>

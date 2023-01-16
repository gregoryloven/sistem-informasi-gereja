<form role="form" method='POST' method="post" action="/reservasitobat" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pemesanan Tiket Pengakuan Dosa</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label >Nama Event</label>
                <input type="hidden" name="id" value="{{$list->id}}">
                <input type="text" class="form-control" id='nama' name='nama' value="{{$list->nama_event}}" readonly>
            </div>
            <div class="form-group">
                <label >Tanggal Tobat</label>
                <input type="text" class="form-control" value="{{tanggal_indonesia( $list->jadwal_pelaksanaan)}}" readonly>
                <input type="hidden" value="{{$list->jadwal_pelaksanaan}}" id='jadwal' name='jadwal'>
            </div>
            <div class="form-group">
                <label >Waktu Tobat</label>
                <input type="text" class="form-control" value="{{waktu_indonesia( $list->jadwal_pelaksanaan)}} WITA" readonly>
            </div>
            <div class="form-group">
                <label >Lokasi</label>
                <input type="text" class="form-control" id='lokasi' name='lokasi' value="{{$list->lokasi}}" readonly>
            </div>
            <div class="form-group">
                <label >Romo</label>
                <input type="text" class="form-control" id='romo' name='romo' value="{{$list->romo}}" readonly>
            </div>
            <div class="form-group">
                <label >Jumlah Tiket</label>
                <input type="number" class="form-control" id='jumlah_tiket' name='jumlah_tiket' min="1" max="5" value="1" required>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="kuota" value="{{$list->kuota}}">
            <button type="submit" class="btn btn-info">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>
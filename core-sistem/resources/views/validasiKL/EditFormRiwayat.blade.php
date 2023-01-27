<form role="form" method='POST' action="{{ url('validasiKL/validasiumatriwayat/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Validasi Data Umat -  {{$data->nama_lengkap}}</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-group">
            <label >Baptis</label>
            <input type="hidden" name="id" value="{{$data->id}}">
            <input type="checkbox" id="baptiss" name="baptis">
        </div>
        <div class="form-group">
            <label >Komuni</label>
            <input type="checkbox" id="komunii" name="komuni">
        </div>
        <div class="form-group">
            <label >Krisma</label>
            <input type="checkbox" id="krismaa" name="krisma">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>

<form role="form" method='POST' action="{{ url('validasiKL/validasiumat/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Validasi Data Umat -  {{$data->nama_lengkap}}</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-group">
            <label >Lingkungan & KBG</label>
            <input type="hidden" name="id" value="{{$data->id}}">
            <input type="checkbox" id="lingkungan" name="lingkungan">
        </div>
        <div class="form-group">
            <label >Baptis</label>
            <input type="checkbox" id="baptis" name="baptis">
        </div>
        <div class="form-group">
            <label >Komuni</label>
            <input type="checkbox" id="komuni" name="komuni">
        </div> 
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>

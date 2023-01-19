<form role="form" method='POST' action="{{ url('pendaftaranumat/validasilingkungan/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Validasi Lingkungan & KBG Asal</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-group">
            <input type="hidden" name="id" value="{{$data->id}}">
            <label >Lingkungan</label>
            <select class="form-control" id='lingkungan_id' name='lingkungan_id'>
            <option value="" disabled selected>Choose</option>
            @foreach($ling as $l)
            <option value="{{ $l->id }}">{{ $l->nama_lingkungan }} ({{$l->batasan_wilayah}})</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label >KBG</label>
            <select class="form-control" id='kbg_id' name='kbg_id'>
                <option value="" disabled selected>Choose</option>
            </select>
        </div> 
        <div class="form-group">
            <label>Surat Baptis</label>
            <input type="file" value="" name="surat_baptis" class="form-control" id="surat_baptis" placeholder="Surat Baptis" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
            <img id="output" width="80px" height="80px">
        </div>
        <div class="form-group">
            <label>Sertifikat Komuni</label>
            <input type="file" value="" name="sertifikat_komuni" class="form-control" id="sertifikat_komuni" placeholder="Sertifikat Komuni" onchange="document.getElementById('output2').src = window.URL.createObjectURL(this.files[0])" required>
            <img id="output2" width="80px" height="80px">
        </div>   
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>

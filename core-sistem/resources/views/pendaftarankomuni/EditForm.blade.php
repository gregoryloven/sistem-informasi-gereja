<form role="form" method='POST' action="{{ url('pendaftarankomuni/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Pendaftaran Komuni Pertama</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <input type="hidden" name="id" value="{{$data->id}}">
                <label >Nama Lengkap Penerima Komuni Pertama</label>
                <input type="text" value="{{$data->nama_lengkap}}" class="form-control" id='nama_lengkap' name='nama_lengkap' placeholder="Nama Lengkap" required>
            </div>    
            <div class="form-group">
                <label >Tempat Lahir</label>
                <input type="text" value="{{$data->tempat_lahir}}" class="form-control" id='tempat_lahir' name='tempat_lahir' placeholder="Tempat Lahir" required>
            </div>   
            <div class="form-group">
                <label >Tanggal Lahir</label>
                <input type="date" value="{{$data->tanggal_lahir}}" class="form-control" id='tanggal_lahir' name='tanggal_lahir' placeholder="Tanggal Lahir" required>
            </div>   
            <div class="form-group">
                <label >Orang Tua Ayah</label>
                <input type="text" value="{{$data->orangtua_ayah}}" class="form-control" id='orangtua_ayah' name='orangtua_ayah' placeholder="Nama Lengkap" required>
            </div>  
            <div class="form-group">
                <label >Orang Tua Ibu</label>
                <input type="text" value="{{$data->orangtua_ibu}}" class="form-control" id='orangtua_ibu' name='orangtua_ibu' placeholder="Nama Lengkap" required>
            </div>  
            <div class="form-group">
                <label >Lingkungan</label>
                <input type="text" value="{{$data->lingkungan}}" class="form-control" id='lingkungan' name='lingkungan' placeholder="Lingkungan" required readonly>
            </div>       
            <div class="form-group">
                <label >KBG</label>
                <input type="text" value="{{$data->kbg}}" class="form-control" id='kbg' name='kbg' placeholder="KBG" required readonly>
            </div>           
            <div class="form-group">
                <label >Telepon</label>
                <input type="text" value="{{$data->telepon}}" class="form-control" id='telepon' name='telepon' placeholder="Telepon" required>
            </div>
            <div class="form-group">
                <label >Tanggal Pelaksanaan</label>
                <input type="text" value="{{tanggal_indonesia($data->jadwal)}}" class="form-control" placeholder="Tanggal Pembaptisan" required readonly>
                <input type="hidden" value="{{$data->jadwal}}" id='jadwal' name='jadwal'>
            </div>
            <div class="form-group">
                <label >Waktu Pelaksanaan</label>
                <input type="text" value="{{waktu_indonesia($data->jadwal)}}" class="form-control" placeholder="Tanggal Pembaptisan" required readonly>
            </div>
            <div class="form-group">
                <label >Lokasi</label>
                <input type="text" value="{{$data->lokasi}}" class="form-control" id='lokasi' name='lokasi' placeholder="Lokasi" required readonly>
            </div>
            <div class="form-group">
                <label >Romo</label>
                <input type="text" value="{{$data->romo}}" class="form-control" id='romo' name='romo' placeholder="Romo" required readonly>
            </div>
            <div class="form-group">
                <label>Surat Baptis</label>
                <input type="file" value="{{$data->surat_baptis}}" name="surat_baptis" class="form-control" id="surat_baptis" placeholder="Surat Baptis" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                <img id="output" src="{{asset('file_sertifikat/surat_baptis/'.$data->surat_baptis)}}" width="80px" height="80px">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>
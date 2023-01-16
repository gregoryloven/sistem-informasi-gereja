<form role="form" method='POST' action="{{ url('pendaftaranumat/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Pendaftaran Umat Baru</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <input type="hidden" name="id" value="{{$data->id}}">
                <label >Nama Lengkap</label>
                <input type="text" value="{{$data->nama_lengkap}}" class="form-control" id='nama_lengkap' name='nama_lengkap' placeholder="Nama Lengkap" required>
            </div>      
            <div class="form-group">
                <label >Hubungan Darah</label>
                <select class="form-control" id='hubungan_darah' name='hubungan_darah' required>
                    <option value="{{$data->hubungan}}" selected>{{$data->hubungan}}</option>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                </select>
            </div> 
            <div class="form-group">
                <label >Jenis Kelamin</label>
                <select class="form-control" id='jenis_kelamin' name='jenis_kelamin' required>
                    <option value="{{$data->jenis_kelamin}}" selected>{{$data->jenis_kelamin}}</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label >Lingkungan</label>
                <input type="text" value="{{$data->lingkungan->nama_lingkungan}}" class="form-control" id='lingkungan' name='lingkungan' placeholder="Lingkungan" readonly>
            </div>       
            <div class="form-group">
                <label >KBG</label>
                <input type="text" value="{{$data->kbg->nama_kbg}}" class="form-control" id='kbg' name='kbg' placeholder="KBG" readonly>
            </div>   
            <div class="form-group">
                <label >Alamat</label>
                <input type="text" value="{{$data->alamat}}" class="form-control" id='alamat' name='alamat' placeholder="Alamat" required>
            </div>        
            <div class="form-group">
                <label >Telepon</label>
                <input type="text" value="{{$data->telepon}}" class="form-control" id='telepon' name='telepon' placeholder="Telepon" required>
            </div>
            <div class="form-group">
                <label>Foto KTP / Tanda Pengenal Yang Berisi Informasi Agama</label>
                <input type="file" value="{{$data->foto_ktp}}" class="form-control" name="foto_ktp"  id="foto_ktp" placeholder="Foto Tanda Pengenal" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                <img id="output" src="{{asset('tanda_pengenal/'.$data->foto_ktp)}}" width="80px" height="80px">
            </div>
            <div class="form-group">
                <label >Nomor Kartu Keluarga</label>
                <input type="number" value="{{$data->no_kk}}" class="form-control" id='no_kk' name='no_kk' placeholder="Nomor Kartu Keluarga" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>
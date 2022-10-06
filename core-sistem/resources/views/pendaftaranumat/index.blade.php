@extends('layouts.sbuser')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Pendaftaran Umat
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">
<svg width="35" height="35" viewBox="0 0 348 512" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M338.569 105.162H278.991V66.075C278.991 63.206 277.605 60.514 275.271 58.846L257.544 46.184C263.462 34.227 261.459 19.315 251.515 9.371C245.472 3.328 237.44 0 228.9 0C220.36 0 212.328 3.328 206.285 9.371C193.819 21.837 193.819 42.122 206.285 54.589C212.327 60.632 220.359 63.96 228.9 63.96C234.82 63.96 240.492 62.359 245.43 59.366L261.224 70.647V105.162H86.777V70.647L102.568 59.367C107.502 62.36 113.175 63.96 119.095 63.96C127.637 63.96 135.667 60.632 141.704 54.589C147.747 48.552 151.075 40.522 151.075 31.98C151.075 23.435 147.745 15.405 141.708 9.376C135.67 3.33 127.639 0 119.095 0C110.551 0 102.52 3.33 96.49 9.368C90.445 15.405 87.115 23.436 87.115 31.981C87.115 36.998 88.271 41.835 90.441 46.196L72.73 58.847C70.395 60.515 69.01 63.207 69.01 66.076V105.163H9.43098C4.52498 105.163 0.547974 109.14 0.547974 114.046V163.793C0.547974 168.699 4.52498 172.676 9.43098 172.676H19.421L55.572 504.079C56.064 508.586 59.869 511.999 64.403 511.999H283.587C288.12 511.999 291.927 508.585 292.418 504.079L328.579 172.676H338.569C343.475 172.676 347.452 168.699 347.452 163.793V114.046C347.453 109.14 343.475 105.162 338.569 105.162ZM238.953 42.027C233.41 47.57 224.391 47.57 218.848 42.027C213.308 36.487 213.308 27.474 218.848 21.935C221.62 19.163 225.261 17.778 228.9 17.778C232.539 17.778 236.181 19.164 238.952 21.935C244.492 27.475 244.492 36.488 238.953 42.027ZM109.052 21.93C111.734 19.245 115.3 17.767 119.095 17.767C122.89 17.767 126.456 19.246 129.145 21.939C131.829 24.621 133.308 28.186 133.308 31.981C133.308 35.776 131.829 39.342 129.145 42.024C129.143 42.026 129.14 42.029 129.137 42.032C126.455 44.717 122.889 46.195 119.094 46.195C115.299 46.195 111.733 44.717 109.044 42.025C106.36 39.343 104.881 35.778 104.881 31.982C104.882 28.185 106.36 24.62 109.052 21.93ZM118.923 154.909C114.017 154.909 110.04 158.886 110.04 163.792C110.04 168.698 114.017 172.675 118.923 172.675H310.707L275.62 494.233H72.369L37.292 172.676H88.718C93.624 172.676 97.601 168.699 97.601 163.793C97.601 158.887 93.624 154.91 88.718 154.91H18.314V122.93H329.684V154.91H118.923V154.909Z" fill="black"/>
    <path d="M240.188 253.101H208.646V215.317C208.646 210.411 204.669 206.434 199.763 206.434H148.239C143.333 206.434 139.356 210.411 139.356 215.317V253.101H107.814C102.908 253.101 98.931 257.078 98.931 261.984V313.496C98.931 318.402 102.908 322.379 107.814 322.379H139.356V437.39C139.356 442.296 143.333 446.273 148.239 446.273H199.763C204.669 446.273 208.646 442.296 208.646 437.39V372.398C208.646 367.492 204.669 363.515 199.763 363.515C194.857 363.515 190.88 367.492 190.88 372.398V428.507H157.123V313.497C157.123 308.591 153.146 304.614 148.24 304.614H116.698V270.869H148.24C153.146 270.869 157.123 266.892 157.123 261.986V224.2H190.88V261.984C190.88 266.89 194.857 270.867 199.763 270.867H231.305V304.612H199.763C194.857 304.612 190.88 308.589 190.88 313.495V342.785C190.88 347.691 194.857 351.668 199.763 351.668C204.669 351.668 208.646 347.691 208.646 342.785V322.38H240.188C245.094 322.38 249.071 318.403 249.071 313.497V261.985C249.072 257.078 245.094 253.101 240.188 253.101Z" fill="black"/>
</svg>
    Pendaftaran Umat
</h1>
@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row mb-4 mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-3">
                Formulir Pendaftaran Umat
            </div>
            
            @if (Auth::User()->status == 'Tervalidasi')
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    Anda Telah Terdaftar Sebagai Umat Pada Lingkungan & Kbg Berikut!<br>
                </div>
                <div class="form-group">
                    <label >Lingkungan</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->lingkungan->nama_lingkungan }}" disabled>
                </div>
                <div class="form-group">
                    <label>KBG</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->kbg->nama_kbg }}" disabled>
                </div>
                @foreach($umatlama as $d)
                @if($d->status == 'Tervalidasi') 
                <div class="alert alert-success" role="alert">
                    <b>{{$d->status}}</b><small><b> -- Pada:</b> {{tanggal_indonesia($d->updated_at)}}, {{waktu_indonesia($d->updated_at)}}</small>
                </div>
                @endif
                @endforeach
            </div>
            @elseif(Auth::User()->status == 'Belum Tervalidasi')
            <div class="card-body">
                <div class="form-group">
                    <label >Lingkungan</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->lingkungan->nama_lingkungan }}" disabled>
                </div>
                <div class="form-group">
                    <label>KBG</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->kbg->nama_kbg }}" disabled>
                </div>
                @foreach($umatlama as $d)
                @if($d->status == 'Belum Tervalidasi') 
                <div class="alert alert-info" role="alert">
                    <b>{{$d->status}}</b><small><b> -- Pendaftaran Pada:</b> {{tanggal_indonesia($d->created_at)}}, {{waktu_indonesia($d->created_at)}}</small>
                </div>
                <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-xs btn-flat btn-danger">Batal</a>
                <!-- EDIT WITH MODAL -->
                <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" >
                            <form role="form" method="POST" action="{{ url('pendaftaranumat/Pembatalan') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Pembatalan Pendaftaran Umat Lama</h4>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-body">
                                    <input type="hidden" name="id" value="{{$d->id}}">
                                    <h6> Apakah Anda Yakin Ingin Membatalkan Pendaftaran? </h6>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="card-body">
            @if(Auth::User()->lingkungan_id !== null && Auth::User()->kbg_id !== null)
                @foreach($umatlama as $d)
                @if($d->status == 'Ditolak') 
                <div class="alert alert-danger" role="alert">
                    <b>DITOLAK</b><br><br><small><b>Lingkungan:</b> {{$d->lingkungan->nama_lingkungan}}<br> <b>KBG:</b> {{$d->kbg->nama_kbg}}<b><br>
                        Pada:</b> {{tanggal_indonesia($d->updated_at)}}, {{waktu_indonesia($d->updated_at)}}<br><br><b>Silahkan Mendaftar Kembali!</b></small>  
                </div>
                @endif
                @endforeach
            @endif
            

            <div class="form-group">
                <label for="exampleFormControlInput1">Pilih Pendaftaran</label>
                <div class="d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" onclick="tabSelect(this.value)" type="radio" name="jenis" id="umatLamaTab" value="umatLama" checked>
                        <label class="form-check-label" for="umatLamaTab">
                            Umat Lama
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" onclick="tabSelect(this.value)" type="radio" name="jenis" id="umatBaruTab" value="umatBaru">
                        <label class="form-check-label" for="umatBaruTab">
                            Umat Baru
                        </label>
                    </div>
                </div>
            </div>
            <form id="formLama" class="mb-2" method="POST" action="{{ url('pendaftaranumat/InputFormLama') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label >Lingkungan</label>
                    <select class="form-control" id='lingkungan_id_lama' name='lingkungan_id_lama' required>
                    <option value="" selected>Choose</option>
                    @foreach($ling as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_lingkungan }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >KBG</label>
                    <select class="form-control" id='kbg_id_lama' name='kbg_id_lama' required>
                    <option value="" disabled selected>Choose</option>
                    {{-- @foreach($kbg as $k) --}}
                    {{-- <option value="{{ $k->id }}">{{ $k->nama_kbg }}</option> --}}
                    {{-- @endforeach --}}
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Formulir</button> 
            </form>
            <form id="formBaru" class="mb-2" method="POST" action="{{ url('pendaftaranumat/InputFormBaru') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label >Nama Lengkap</label>
                    <input type="text" class="form-control" id='nama_lengkap' name='nama_lengkap' placeholder="Nama Lengkap" required>
                </div> 
                <div class="form-group">
                <label >Hubungan Darah</label>
                    <select class="form-control" id='hubungan_darah' name='hubungan_darah' required>
                        <option value="" disabled selected>Choose</option>
                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Jenis Kelamin</label>
                    <select class="form-control" id='jenis_kelamin' name='jenis_kelamin' required>
                        <option value="" disabled selected>Choose</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Lingkungan</label>
                    <select class="form-control" id='lingkungan_id_baru' name='lingkungan_id_baru'>
                    <option value="" disabled selected>Choose</option>
                    @foreach($ling as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_lingkungan }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >KBG</label>
                    <select class="form-control" id='kbg_id_baru' name='kbg_id_baru'>
                        <option value="" disabled selected>Choose</option>
                    </select>
                </div>

                <div class="form-group">
                    <label >Alamat</label>
                    <input type="text" class="form-control" id='alamat' name='alamat' placeholder="Alamat" required>
                </div>
                <div class="form-group">
                    <label >Telepon</label>
                    <input type="text" class="form-control" id='telepon' name='telepon' placeholder="Telepon" required>
                </div>
                <div class="form-group">
                    <label>Foto KTP / Tanda Pengenal Yang Berisi Informasi Agama</label>
                    <input type="file" class="form-control" name="foto_ktp"  id="foto_ktp" placeholder="Foto Tanda Pengenal" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
                </div>
                <img id="output" src="" width="200px" height="200px">
                <div class="alert alert-info" role="alert">
                    Jika sudah mendaftar, silahkan lihat status pada "Riwayat Pendaftaran Umat Baru"
                </div>
                <input type="hidden" value="" id='event_id' name='event_id'>
                <input type="hidden" value="" id='jenis_event' name='jenis_event'>
                <button type="submit" class="btn btn-primary">Ajukan Formulir</button> 
            </form>
            @endif
        </div>
    </div>
</div>
<div class="row mb-4 mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-3">
                Riwayat Pendaftaran Umat Baru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr style="text-align: center;">
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Hubungan Darah</th>
                            <th>Jenis Kelamin</th>
                            <th>Lingkungan</th>
                            <th>KBG</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($umatbaru as $d)
                            @php $i += 1; @endphp
                            <tr>
                                <td>@php echo $i; @endphp</td>
                                <td st>{{$d->nama_lengkap}}</td>
                                <td st>{{$d->hubungan}}</td>
                                <td st>{{$d->jenis_kelamin}}</td>
                                <td st>{{$d->lingkungan_id}}</td>
                                <td st>{{$d->kbg_id}}</td>
                                <td st>{{$d->alamat}}</td>
                                <td st>{{$d->telepon}}</td>
                                <td st>
                                    @if($d->status == "Diproses" || $d->status == "Disetujui KBG" || $d->status == "Disetujui Lingkungan")
                                    
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-info" onclick="detail({{ $d->id }})">Lacak</a>
                                    
                                    @else
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-danger" onclick="detail({{ $d->id }})">Lacak</a>
                                    @endif
                                </td>
                                <td st>
                                    @if($d->status == "Diproses" || $d->status == "Disetujui KBG")
                                    <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-xs btn-flat btn-danger">Batal</a>
                                    @endif
                                </td>
                            </tr>
                            <!-- EDIT WITH MODAL
                            <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" >
                                        <form role="form" method="POST" action="{{ url('pendaftaranbaptis/Pembatalan') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">Pembatalan Baptis Bayi</h4>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <label>Alasan Pembatalan:</label>
                                                <input type="hidden" name="id" value="{{$d->id}}">
                                                <textarea name="alasan_pembatalan" class="form-control" id="" cols="30" rows="10" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<div>
<!-- /.container-fluid -->
@endsection

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <script>
        $(document).ready(function(){
            $("#umatLamaTab").trigger("click");
            
        });
        function tabSelect(value) {
            if(value === "umatLama"){
                document.getElementById("formLama").style.display = "block";
                document.getElementById("formBaru").style.display = "none";
            }else{
                document.getElementById("formLama").style.display = "none";
                document.getElementById("formBaru").style.display = "block";
            }
        }

        $('#lingkungan_id_lama').change(function(){
            if($(this).val() != '') {
                var value = $(this).val();
                $.ajax({
                    url:`{{ url('fetchkbg') }}`,
                    method:"POST",
                    data:{
                        id:value, 
                        _token: $('[name=csrf-token]').attr('content'), 
                    },
                    success:function(result) {
                        // console.log(result);
                        $('#kbg_id_lama').html(result);
                    }
                })
            }
        });

        $('#lingkungan_id_baru').change(function(){
            if($(this).val() != '') {
                var value = $(this).val();
                $.ajax({
                    url:`{{ url('fetchkbgbaru') }}`,
                    method:"POST",
                    data:{
                        id:value, 
                        _token: $('[name=csrf-token]').attr('content'), 
                    },
                    success:function(result) {
                        // console.log(result);
                        $('#kbg_id_baru').html(result);
                    }
                })
            }
        });
    </script>
@endsection
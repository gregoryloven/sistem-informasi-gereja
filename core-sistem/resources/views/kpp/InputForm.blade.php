@extends('layouts.sbadmin2')

@section('title')
    Kursus Persiapan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">
<svg width="35" height="35" viewBox="0 0 348 512" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M338.569 105.162H278.991V66.075C278.991 63.206 277.605 60.514 275.271 58.846L257.544 46.184C263.462 34.227 261.459 19.315 251.515 9.371C245.472 3.328 237.44 0 228.9 0C220.36 0 212.328 3.328 206.285 9.371C193.819 21.837 193.819 42.122 206.285 54.589C212.327 60.632 220.359 63.96 228.9 63.96C234.82 63.96 240.492 62.359 245.43 59.366L261.224 70.647V105.162H86.777V70.647L102.568 59.367C107.502 62.36 113.175 63.96 119.095 63.96C127.637 63.96 135.667 60.632 141.704 54.589C147.747 48.552 151.075 40.522 151.075 31.98C151.075 23.435 147.745 15.405 141.708 9.376C135.67 3.33 127.639 0 119.095 0C110.551 0 102.52 3.33 96.49 9.368C90.445 15.405 87.115 23.436 87.115 31.981C87.115 36.998 88.271 41.835 90.441 46.196L72.73 58.847C70.395 60.515 69.01 63.207 69.01 66.076V105.163H9.43098C4.52498 105.163 0.547974 109.14 0.547974 114.046V163.793C0.547974 168.699 4.52498 172.676 9.43098 172.676H19.421L55.572 504.079C56.064 508.586 59.869 511.999 64.403 511.999H283.587C288.12 511.999 291.927 508.585 292.418 504.079L328.579 172.676H338.569C343.475 172.676 347.452 168.699 347.452 163.793V114.046C347.453 109.14 343.475 105.162 338.569 105.162ZM238.953 42.027C233.41 47.57 224.391 47.57 218.848 42.027C213.308 36.487 213.308 27.474 218.848 21.935C221.62 19.163 225.261 17.778 228.9 17.778C232.539 17.778 236.181 19.164 238.952 21.935C244.492 27.475 244.492 36.488 238.953 42.027ZM109.052 21.93C111.734 19.245 115.3 17.767 119.095 17.767C122.89 17.767 126.456 19.246 129.145 21.939C131.829 24.621 133.308 28.186 133.308 31.981C133.308 35.776 131.829 39.342 129.145 42.024C129.143 42.026 129.14 42.029 129.137 42.032C126.455 44.717 122.889 46.195 119.094 46.195C115.299 46.195 111.733 44.717 109.044 42.025C106.36 39.343 104.881 35.778 104.881 31.982C104.882 28.185 106.36 24.62 109.052 21.93ZM118.923 154.909C114.017 154.909 110.04 158.886 110.04 163.792C110.04 168.698 114.017 172.675 118.923 172.675H310.707L275.62 494.233H72.369L37.292 172.676H88.718C93.624 172.676 97.601 168.699 97.601 163.793C97.601 158.887 93.624 154.91 88.718 154.91H18.314V122.93H329.684V154.91H118.923V154.909Z" fill="black"/>
    <path d="M240.188 253.101H208.646V215.317C208.646 210.411 204.669 206.434 199.763 206.434H148.239C143.333 206.434 139.356 210.411 139.356 215.317V253.101H107.814C102.908 253.101 98.931 257.078 98.931 261.984V313.496C98.931 318.402 102.908 322.379 107.814 322.379H139.356V437.39C139.356 442.296 143.333 446.273 148.239 446.273H199.763C204.669 446.273 208.646 442.296 208.646 437.39V372.398C208.646 367.492 204.669 363.515 199.763 363.515C194.857 363.515 190.88 367.492 190.88 372.398V428.507H157.123V313.497C157.123 308.591 153.146 304.614 148.24 304.614H116.698V270.869H148.24C153.146 270.869 157.123 266.892 157.123 261.986V224.2H190.88V261.984C190.88 266.89 194.857 270.867 199.763 270.867H231.305V304.612H199.763C194.857 304.612 190.88 308.589 190.88 313.495V342.785C190.88 347.691 194.857 351.668 199.763 351.668C204.669 351.668 208.646 347.691 208.646 342.785V322.38H240.188C245.094 322.38 249.071 318.403 249.071 313.497V261.985C249.072 257.078 245.094 253.101 240.188 253.101Z" fill="black"/>
</svg>
    Pendaftaran Kursus Persiapan Perkawinan
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

<div class="row mb-2 mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-3">
                Formulir Pendaftaran Kursus Persiapan Perkawinan
            </div>
            <div class="card-body">
            <form role="form" class="mb-2" method="post" action="{{ url('kpp') }}" enctype="multipart/form-data">
            @csrf
            <div class="row gutters">
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <small style="color:red;"><label >Bertanda * Wajib Diisi</label></small>
                </div>  -->
                <!-- IDENTITAS CALON SUAMI -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br><h6 class="mb-2 text-primary">Identitas Calon Suami</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" id='nama_lengkap_calon_suami' name='nama_lengkap_calon_suami' placeholder="Nama Lengkap Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Tempat Lahir</label>
                        <input type="text" class="form-control" id='tempat_lahir_calon_suami' name='tempat_lahir_calon_suami' placeholder="Tempat Lahir Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Tanggal Lahir</label>
                        <input type="date" class="form-control" id='tanggal_lahir_calon_suami' name='tanggal_lahir_calon_suami' placeholder="Tanggal Lahir Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Nama Lengkap Ayah</label>
                        <input type="text" class="form-control" id='nama_ayah_calon_suami' name='nama_ayah_calon_suami' placeholder="Nama Ayah Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Nama Lengkap Ibu</label>
                        <input type="text" class="form-control" id='nama_ibu_calon_suami' name='nama_ibu_calon_suami' placeholder="Nama Ibu Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Alamat</label>
                        <input type="text" class="form-control" id='alamat_calon_suami' name='alamat_calon_suami' placeholder="Alamat Calon Suami" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Telepon</label>
                        <input type="text" class="form-control" id='telepon_calon_suami' name='telepon_calon_suami' placeholder="Telepon Calon Suami" required>
                    </div> 
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Agama</label>
                        <select class="form-control" id='agama_calon_suami' name='agama_calon_suami' onchange='checkAgamaSuami(this)' required>
                            <option value="" disabled selected>Choose</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Islam">Islam</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Khonghucu">Khonghucu</option>
                        </select>
                    </div>
                </div>
                @if(\Spatie\Multitenancy\Models\Tenant::checkCurrent())
                <div style='display:none' id='label_paroki_calon_suami' class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Paroki Asal</label>
                        <select class="form-control" id='paroki_calon_suami' name='paroki_calon_suami' onchange='checkParokiSuami(this)' required>
                            <option value="" disabled selected>Choose</option>
                            <option value="{{app('currentTenant')->name}}">{{app('currentTenant')->name}}</option>
                            <option value="Paroki Luar">Paroki Luar</option>
                        </select>
                    </div> 
                </div> 
                @endif
                <div style='display:none' id='label_nik_calon_suami' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >NIK</label>
                        <input type="number" class="form-control" id='nik_calon_suami' name='nik_calon_suami' placeholder="NIK Calon Suami" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" required>
                    </div>
                </div> 
                <div style='display:none' id='label_ktp_calon_suami' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >KTP</label>
                        <input type="file" class="form-control" id='ktp_calon_suami' name='ktp_calon_suami' onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
                        <img id="output" width="100px" height="100px">
                    </div>
                </div>
                <div style='display:none' id='label_suratpengantar_lingkungan_calon_suami' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Surat Pengantar Lingkungan</label>
                        <input type="file" class="form-control" id='suratpengantar_lingkungan_calon_suami' name='suratpengantar_lingkungan_calon_suami' onchange="document.getElementById('output2').src = window.URL.createObjectURL(this.files[0])">
                        <img id="output2" width="100px" height="100px">
                    </div>
                </div>
                <div style='display:none' id='label_suratpengantar_paroki_calon_suami' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Surat Pengantar Paroki Luar</label>
                        <input type="file" class="form-control" id='suratpengantar_paroki_calon_suami' name='suratpengantar_paroki_calon_suami' onchange="document.getElementById('output3').src = window.URL.createObjectURL(this.files[0])">
                        <img id="output3" width="100px" height="100px">
                    </div>
                </div>

                <!-- IDENTITAS CALON ISTRI -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <br><h6 class="mb-2 text-primary">Identitas Calon Istri</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" id='nama_lengkap_calon_istri' name='nama_lengkap_calon_istri' placeholder="Nama Lengkap Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Tempat Lahir</label>
                        <input type="text" class="form-control" id='tempat_lahir_calon_istri' name='tempat_lahir_calon_istri' placeholder="Tempat Lahir Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Tanggal Lahir</label>
                        <input type="date" class="form-control" id='tanggal_lahir_calon_istri' name='tanggal_lahir_calon_istri' placeholder="Tanggal Lahir Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Nama Lengkap Ayah</label>
                        <input type="text" class="form-control" id='nama_ayah_calon_istri' name='nama_ayah_calon_istri' placeholder="Nama Ayah Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Nama Lengkap Ibu</label>
                        <input type="text" class="form-control" id='nama_ibu_calon_istri' name='nama_ibu_calon_istri' placeholder="Nama Ibu Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Alamat</label>
                        <input type="text" class="form-control" id='alamat_calon_istri' name='alamat_calon_istri' placeholder="Alamat Calon Istri" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Telepon</label>
                        <input type="text" class="form-control" id='telepon_calon_istri' name='telepon_calon_istri' placeholder="Telepon Calon Istri" required>
                    </div> 
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Agama</label>
                        <select class="form-control" id='agama_calon_istri' name='agama_calon_istri' onchange='checkAgamaIstri(this)' required>
                            <option value="" disabled selected>Choose</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Islam">Islam</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Khonghucu">Khonghucu</option>
                        </select>
                    </div>
                </div>
                @if(\Spatie\Multitenancy\Models\Tenant::checkCurrent())
                <div style='display:none' id='label_paroki_calon_istri' class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Paroki Asal</label>
                        <select class="form-control" id='paroki_calon_istri' name='paroki_calon_istri' onchange='checkParokiIstri(this)' required>
                            <option value="" disabled selected>Choose</option>
                            <option value="{{app('currentTenant')->name}}">{{app('currentTenant')->name}}</option>
                            <option value="Paroki Luar">Paroki Luar</option>
                        </select>
                    </div> 
                </div> 
                @endif
                <div style='display:none' id='label_nik_calon_istri' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >NIK</label>
                        <input type="number" class="form-control" id='nik_calon_istri' name='nik_calon_istri' placeholder="NIK Calon Istri" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" required>
                    </div>
                </div> 
                <div style='display:none' id='label_ktp_calon_istri' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >KTP</label>
                        <input type="file" class="form-control" id='ktp_calon_istri' name='ktp_calon_istri' onchange="document.getElementById('output4').src = window.URL.createObjectURL(this.files[0])" required>
                        <img id="output4" width="100px" height="100px">
                    </div>
                </div>
                <div style='display:none' id='label_suratpengantar_lingkungan_calon_istri' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Surat Pengantar Lingkungan</label>
                        <input type="file" class="form-control" id='suratpengantar_lingkungan_calon_istri' name='suratpengantar_lingkungan_calon_istri' onchange="document.getElementById('output5').src = window.URL.createObjectURL(this.files[0])">
                        <img id="output5" width="100px" height="100px">
                    </div>
                </div>
                <div style='display:none' id='label_suratpengantar_paroki_calon_istri' class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Surat Pengantar Paroki Luar</label>
                        <input type="file" class="form-control" id='suratpengantar_paroki_calon_istri' name='suratpengantar_paroki_calon_istri' onchange="document.getElementById('output6').src = window.URL.createObjectURL(this.files[0])">
                        <img id="output6" width="100px" height="100px">
                    </div>
                </div>

                <!-- HAL LAIN -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Tempat Kursus</label>
                        <input type="text" class="form-control" value="{{$list[0]->lokasi}}" id='lokasi' name='lokasi' required readonly>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label >Keterangan Kursus</label>
                        <input type="text" class="form-control" value="{{$list[0]->keterangan_kursus}}" id='keterangan_kursus' name='keterangan_kursus' required readonly>
                    </div>
                </div>

                <!-- CHECKBOX & BUTTON -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <br><input type="checkbox" id="terms" name="terms" onchange="checkbox()">
                        <label>Saya Menyetujui Formulir Pendaftaran Ini</label>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <input type="hidden" value="{{$list[0]->id}}" id='list_event_id' name='list_event_id'>
                        <input type="hidden" value="{{$list[0]->jenis_event}}" id='jenis_event' name='jenis_event'>
                        <button type="submit" class="btn btn-primary" id="button" disabled>Ajukan Formulir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('javascript')
<script>
function checkbox()
{
    var cek = $('#terms').is(':checked')

    if(cek == true)
    {
        $('#button').attr('disabled', false)
    }
    else
    {
        $('#button').attr('disabled', true)
    }
}

function checkParokiSuami(paroki)
{
    if($(paroki).val() == '{{app('currentTenant')->name}}')
    {
        $('#label_suratpengantar_lingkungan_calon_suami').show()
        $('#label_suratpengantar_paroki_calon_suami').hide()

        $('#suratpengantar_paroki_calon_suami').prop('required',false)
    }
    else
    {
        $('#label_suratpengantar_paroki_calon_suami').show()
        $('#label_suratpengantar_lingkungan_calon_suami').hide()

        $('#suratpengantar_lingkungan_calon_suami').prop('required',false)
    }
}

function checkAgamaSuami(agama)
{

    if($(agama).val() == 'Katolik')
    {
        $('#label_nik_calon_suami').show()
        $('#label_ktp_calon_suami').show()
        $('#label_paroki_calon_suami').show()
    }
    else
    {
        $('#label_nik_calon_suami').show()
        $('#label_ktp_calon_suami').show()
        $('#label_paroki_calon_suami').hide()

        $('#paroki_calon_suami').prop('required',false)
    }
}

function checkAgamaIstri(agama)
{

    if($(agama).val() == 'Katolik')
    {
        $('#label_nik_calon_istri').show()
        $('#label_ktp_calon_istri').show()
        $('#label_paroki_calon_istri').show()
    }
    else
    {        
        $('#label_nik_calon_istri').show()
        $('#label_ktp_calon_istri').show()
        $('#label_paroki_calon_istri').hide()

        $('#paroki_calon_istri').prop('required',false)
    }
}

function checkParokiIstri(paroki)
{
    if($(paroki).val() == '{{app('currentTenant')->name}}')
    {
        $('#label_suratpengantar_lingkungan_calon_istri').show()
        $('#label_suratpengantar_paroki_calon_istri').hide()

        $('#suratpengantar_paroki_calon_istri').prop('required',false)
    }
    else
    {
        $('#label_suratpengantar_paroki_calon_istri').show()
        $('#label_suratpengantar_lingkungan_calon_istri').hide()

        $('#suratpengantar_lingkungan_calon_istri').prop('required',false)
    }
}
</script>
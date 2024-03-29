@extends('layouts.sbuser')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Pendaftaran Sakramen Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">
<svg width="35" height="35" viewBox="0 0 348 512" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M338.569 105.162H278.991V66.075C278.991 63.206 277.605 60.514 275.271 58.846L257.544 46.184C263.462 34.227 261.459 19.315 251.515 9.371C245.472 3.328 237.44 0 228.9 0C220.36 0 212.328 3.328 206.285 9.371C193.819 21.837 193.819 42.122 206.285 54.589C212.327 60.632 220.359 63.96 228.9 63.96C234.82 63.96 240.492 62.359 245.43 59.366L261.224 70.647V105.162H86.777V70.647L102.568 59.367C107.502 62.36 113.175 63.96 119.095 63.96C127.637 63.96 135.667 60.632 141.704 54.589C147.747 48.552 151.075 40.522 151.075 31.98C151.075 23.435 147.745 15.405 141.708 9.376C135.67 3.33 127.639 0 119.095 0C110.551 0 102.52 3.33 96.49 9.368C90.445 15.405 87.115 23.436 87.115 31.981C87.115 36.998 88.271 41.835 90.441 46.196L72.73 58.847C70.395 60.515 69.01 63.207 69.01 66.076V105.163H9.43098C4.52498 105.163 0.547974 109.14 0.547974 114.046V163.793C0.547974 168.699 4.52498 172.676 9.43098 172.676H19.421L55.572 504.079C56.064 508.586 59.869 511.999 64.403 511.999H283.587C288.12 511.999 291.927 508.585 292.418 504.079L328.579 172.676H338.569C343.475 172.676 347.452 168.699 347.452 163.793V114.046C347.453 109.14 343.475 105.162 338.569 105.162ZM238.953 42.027C233.41 47.57 224.391 47.57 218.848 42.027C213.308 36.487 213.308 27.474 218.848 21.935C221.62 19.163 225.261 17.778 228.9 17.778C232.539 17.778 236.181 19.164 238.952 21.935C244.492 27.475 244.492 36.488 238.953 42.027ZM109.052 21.93C111.734 19.245 115.3 17.767 119.095 17.767C122.89 17.767 126.456 19.246 129.145 21.939C131.829 24.621 133.308 28.186 133.308 31.981C133.308 35.776 131.829 39.342 129.145 42.024C129.143 42.026 129.14 42.029 129.137 42.032C126.455 44.717 122.889 46.195 119.094 46.195C115.299 46.195 111.733 44.717 109.044 42.025C106.36 39.343 104.881 35.778 104.881 31.982C104.882 28.185 106.36 24.62 109.052 21.93ZM118.923 154.909C114.017 154.909 110.04 158.886 110.04 163.792C110.04 168.698 114.017 172.675 118.923 172.675H310.707L275.62 494.233H72.369L37.292 172.676H88.718C93.624 172.676 97.601 168.699 97.601 163.793C97.601 158.887 93.624 154.91 88.718 154.91H18.314V122.93H329.684V154.91H118.923V154.909Z" fill="black"/>
    <path d="M240.188 253.101H208.646V215.317C208.646 210.411 204.669 206.434 199.763 206.434H148.239C143.333 206.434 139.356 210.411 139.356 215.317V253.101H107.814C102.908 253.101 98.931 257.078 98.931 261.984V313.496C98.931 318.402 102.908 322.379 107.814 322.379H139.356V437.39C139.356 442.296 143.333 446.273 148.239 446.273H199.763C204.669 446.273 208.646 442.296 208.646 437.39V372.398C208.646 367.492 204.669 363.515 199.763 363.515C194.857 363.515 190.88 367.492 190.88 372.398V428.507H157.123V313.497C157.123 308.591 153.146 304.614 148.24 304.614H116.698V270.869H148.24C153.146 270.869 157.123 266.892 157.123 261.986V224.2H190.88V261.984C190.88 266.89 194.857 270.867 199.763 270.867H231.305V304.612H199.763C194.857 304.612 190.88 308.589 190.88 313.495V342.785C190.88 347.691 194.857 351.668 199.763 351.668C204.669 351.668 208.646 347.691 208.646 342.785V322.38H240.188C245.094 322.38 249.071 318.403 249.071 313.497V261.985C249.072 257.078 245.094 253.101 240.188 253.101Z" fill="black"/>
</svg>
    Pendaftaran Sakramen Perkawinan
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
<small style="color:red;">*Anda hanya dapat mengajukan pendaftaran sebanyak 1 kali. Jika ingin mengajukan kembali harap tekan "Batal" atau hubungi sekretariat paroki.</small><br>
@if(count($data)==0)
<a href="{{ url('pendaftaranperkawinan/create') }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Formulir Pendaftaran</a><br><br>
@endif

<!-- TRACKING WITH MODAL -->
<div class="modal fade" id="modaltracking" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContentt">
            <div style="text-align: center;">
                <!-- <img src="{{ asset('res/loading.gif') }}"> -->
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Pendaftaran 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($data)!=0)
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center;">
                        <th>KETERANGAN IDENTITAS</th>
                        <th>CALON SUAMI</th>
                        <th>CALON ISTRI</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>{{$d->nama_lengkap_calon_suami}}</td>
                        <td>{{$d->nama_lengkap_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Tempat, Tgl Lahir</td>
                        <td>{{$d->tempat_lahir_calon_suami}}, {{tanggal_indonesia($d->tanggal_lahir_calon_suami)}}</td>
                        <td>{{$d->tempat_lahir_calon_istri}}, {{tanggal_indonesia($d->tanggal_lahir_calon_istri)}}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>{{$d->pekerjaan_calon_suami}}</td>
                        <td>{{$d->pekerjaan_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{$d->alamat_calon_suami}}</td>
                        <td>{{$d->alamat_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>{{$d->telepon_calon_suami}}</td>
                        <td>{{$d->telepon_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>{{$d->agama_calon_suami}}</td>
                        <td>{{$d->agama_calon_istri}}</td>
                    </tr>
                    @if($d->agama_calon_suami == 'Katolik' || $d->agama_calon_istri == 'Katolik')
                    <tr>
                        <td>Paroki</td>
                        <td>{{$d->paroki_calon_suami}}</td>
                        <td>{{$d->paroki_calon_istri}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><b>IDENTITAS ORANG TUA</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap Ayah</td>
                        <td>{{$d->nama_ayah_calon_suami}}</td>
                        <td>{{$d->nama_ayah_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>{{$d->agama_ayah_calon_suami}}</td>
                        <td>{{$d->agama_ayah_calon_suami}}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>{{$d->pekerjaan_ayah_calon_suami}}</td>
                        <td>{{$d->pekerjaan_ayah_calon_istri}}</td>

                    </tr>
                    <tr>
                        <td>Nama Lengkap Ibu</td>
                        <td>{{$d->nama_ibu_calon_suami}}</td>
                        <td>{{$d->nama_ibu_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>{{$d->agama_ibu_calon_suami}}</td>
                        <td>{{$d->agama_ibu_calon_suami}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{$d->alamat_orangtua_calon_suami}}</td>
                        <td>{{$d->alamat_orangtua_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td><b>LAMPIRAN PRIBADI</b></td><td></td><td></td>
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami=="Katolik" || $d->agama_calon_istri=="Katolik" || $d->agama_calon_suami=="Kristen" || $d->agama_calon_istri=="Kristen")    
                        <td>Surat Baptis + Status Liber</td>
                        <td>@if(isset($d->surat_baptis_calon_suami))<a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->surat_baptis_calon_istri))<a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami=="Katolik" || $d->agama_calon_istri=="Katolik")
                        <td>Sertifikat Komuni</td>
                        <td>@if(isset($d->sertifikat_komuni_calon_suami))<a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->sertifikat_komuni_calon_istri))<a href="#modalPopUp4{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->sertifikat_krisma_calon_suami != null || $d->sertifikat_krisma_calon_istri != null)
                        <td>Sertifikat Krisma</td>
                        <td>@if(isset($d->sertifikat_krisma_calon_suami))<a href="#modalPopUp5{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->sertifikat_krisma_calon_istri))<a href="#modalPopUp6{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_lingkungan_calon_suami) || isset($d->suratpengantar_lingkungan_calon_istri))
                        <td>Surat Pengantar Lingkungan</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_suami))<a href="#modalPopUp7{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_istri))<a href="#modalPopUp8{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_paroki_calon_suami) || isset($d->suratpengantar_paroki_calon_istri))
                        <td>Surat Pengantar Paroki</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_suami))<a href="#modalPopUp9{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_istri))<a href="#modalPopUp10{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>{{$d->nik_calon_suami}}</td>
                        <td>{{$d->nik_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>KTP</td>
                        <td><a href="#modalPopUp11{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_suami)}}" height='80px'/></td>
                        <td><a href="#modalPopUp12{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                        <td>KK</td>
                        <td><a href="#modalPopUp13{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_suami)}}" height='80px'/></td>
                        <td><a href="#modalPopUp14{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami!="Katolik" || $d->agama_calon_istri!="Katolik")
                        <td>Surat Keterangan Bebas Menikah</td>
                        <td>@if(isset($d->suratketerangan_bebas_menikah_calon_suami))<a href="#modalPopUp15{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratketerangan_bebas_menikah_calon_istri))<a href="#modalPopUp16{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami!="Katolik" || $d->agama_calon_istri!="Katolik")
                        <td>Surat Pernyataan Pihak Non-Katolik</td>
                        <td>@if(isset($d->suratpernyataan_nonkatolik_calon_suami))<a href="#modalPopUp17{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpernyataan_nonkatolik/'.$d->suratpernyataan_nonkatolik_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpernyataan_nonkatolik_calon_istri))<a href="#modalPopUp18{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpernyataan_nonkatolik/'.$d->suratpernyataan_nonkatolik_calon_istri)}}" height='80px'/>@endif</td>                    
                    @endif
                    </tr>
                    <tr>
                        <td>Tanda Tangan</td>
                        <td><a href="#modalPopUp19{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ttd/'.$d->ttd_calon_suami)}}" height='80px'/></td>
                        <td><a href="#modalPopUp20{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ttd/'.$d->ttd_calon_istri)}}" height='80px'/></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center;">
                        <th>LAMPIRAN PER-PASANGAN</th>
                        <th>Sertifikat KPP</th>
                        <th>Foto 4x6 Berdampingan</th>
                        <th>KTP Saksi Nikah</th>
                        <th>Tanggal Kanonik</th>
                    </tr>
                    <tbody>
                        <tr style="text-align: center;">
                            <td></td>
                            <td><a href="#modalPopUp21{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_kpp/'.$d->sertifikat_kpp)}}" height='80px'/></td>
                            <td><a href="#modalPopUp22{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/foto_berdampingan/'.$d->foto_berdampingan)}}" height='80px'/></td>
                            <td><a href="#modalPopUp23{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ktp_saksi_nikah/'.$d->ktp_saksi_nikah)}}" height='80px'/></td>
                            <td>{{tanggal_indonesia($d->tanggal_kanonik)}}</td>
                        </tr>
                    </tbody>
                </thead>

            </table>
            <br><h6><b>Permohonan Tempat,Tanggal, Waktu Pelaksanaan Perkawinan:</b> {{$data[0]->tempat_perkawinan}}, {{tanggal_indonesia($data[0]->tanggal_perkawinan)}}, {{waktu_indonesia($data[0]->tanggal_perkawinan)}} WITA</h6><br>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="d-flex justify-content-end">
                @if($d->status == "Diproses")
                    <a href="{{ url('pendaftaranperkawinan/EditForm/'.$d->id) }}" class="btn btn-xs btn-flat btn-warning">Ubah</a>
                    <form role="form" method="POST" class="ml-1" action="{{ url('pendaftaranperkawinan/'.$d->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                        <input type="hidden" class="form-control" name="jadwal" value="{{$d->tanggal_perkawinan}}">
                        <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('Apakah anda yakin ingin membatalkan pendaftaran ini?')) return false">Batal</button>
                    </form>
                @endif
                    @if($d->status == "Diproses")
                    <a href="#modaltracking" data-toggle="modal" class="btn btn-info ml-1" onclick="detail({{ $d->id }})">Lacak</a>
                    @elseif($d->status == "Disetujui Paroki")
                    <a href="#modaltracking" data-toggle="modal" class="btn btn-success ml-1" onclick="detail({{ $d->id }})">Lacak</a>
                    @else
                    <a href="#modaltracking" data-toggle="modal" class="btn btn-danger ml-1" onclick="detail({{ $d->id }})">Lacak</a>
                    @endif
				</div>
			</div><br>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp2{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp3{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp4{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp5{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp6{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp7{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp8{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp9{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp10{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp11{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp12{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp13{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp14{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp15{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp16{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp17{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpernyataan_nonkatolik/'.$d->suratpernyataan_nonkatolik_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp18{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/suratpernyataan_nonkatolik/'.$d->suratpernyataan_nonkatolik_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp19{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/ttd/'.$d->ttd_calon_suami)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp20{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/ttd/'.$d->ttd_calon_istri)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp21{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/sertifikat_kpp/'.$d->sertifikat_kpp)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp22{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/foto_berdampingan/'.$d->foto_berdampingan)}}">
                        </div>
                    </div>
                </div>
                <!-- POP UP WITH MODAL -->
                <div class="modal fade" id="modalPopUp23{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px; height=400px;">
                        <div class="modal-content" >
                            <img src="{{asset('file_perkawinan/ktp_saksi_nikah/'.$d->ktp_saksi_nikah)}}">
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script>
function detail(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('pendaftaranperkawinan.detail', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContentt').html(data.msg);
    }
  });
}

</script>
@endsection
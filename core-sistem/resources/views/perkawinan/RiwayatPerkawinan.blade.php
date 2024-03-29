@extends('layouts.sbadmin2')

@section('title')
    Riwayat Validasi Formulir Pendaftaran Sakramen Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4"> Riwayat Validasi Formulir Pendaftaran Sakramen Perkawinan</h1>

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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi Formulir Pendaftaran 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center; color:black;">
                        <th>KETERANGAN IDENTITAS</th>
                        <th>CALON SUAMI</th>
                        <th>CALON ISTRI</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td style="color:black;">Nama Lengkap</td>
                        <td>{{$d->nama_lengkap_calon_suami}}</td>
                        <td>{{$d->nama_lengkap_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Tempat, Tgl Lahir</td>
                        <td>{{$d->tempat_lahir_calon_suami}}, {{tanggal_indonesia($d->tanggal_lahir_calon_suami)}}</td>
                        <td>{{$d->tempat_lahir_calon_istri}}, {{tanggal_indonesia($d->tanggal_lahir_calon_istri)}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Pekerjaan</td>
                        <td>{{$d->pekerjaan_calon_suami}}</td>
                        <td>{{$d->pekerjaan_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Alamat</td>
                        <td>{{$d->alamat_calon_suami}}</td>
                        <td>{{$d->alamat_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Telepon</td>
                        <td>{{$d->telepon_calon_suami}}</td>
                        <td>{{$d->telepon_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Agama</td>
                        <td>{{$d->agama_calon_suami}}</td>
                        <td>{{$d->agama_calon_istri}}</td>
                    </tr>
                    @if($d->agama_calon_suami == 'Katolik' || $d->agama_calon_istri == 'Katolik')
                    <tr>
                        <td style="color:black;">Paroki</td>
                        <td>{{$d->paroki_calon_suami}}</td>
                        <td>{{$d->paroki_calon_istri}}</td>
                    </tr>
                    @endif
                    <tr style="color:black;">
                        <td><b>IDENTITAS ORANG TUA</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td style="color:black;">Nama Lengkap Ayah</td>
                        <td>{{$d->nama_ayah_calon_suami}}</td>
                        <td>{{$d->nama_ayah_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Agama</td>
                        <td>{{$d->agama_ayah_calon_suami}}</td>
                        <td>{{$d->agama_ayah_calon_suami}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Pekerjaan</td>
                        <td>{{$d->pekerjaan_ayah_calon_suami}}</td>
                        <td>{{$d->pekerjaan_ayah_calon_istri}}</td>

                    </tr>
                    <tr>
                        <td style="color:black;">Nama Lengkap Ibu</td>
                        <td>{{$d->nama_ibu_calon_suami}}</td>
                        <td>{{$d->nama_ibu_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Agama</td>
                        <td>{{$d->agama_ibu_calon_suami}}</td>
                        <td>{{$d->agama_ibu_calon_suami}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Alamat</td>
                        <td>{{$d->alamat_orangtua_calon_suami}}</td>
                        <td>{{$d->alamat_orangtua_calon_istri}}</td>
                    </tr>
                    <tr style="color:black;">
                        <td><b>LAMPIRAN PRIBADI</b></td><td></td><td></td>
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami=="Katolik" || $d->agama_calon_istri=="Katolik" || $d->agama_calon_suami=="Kristen" || $d->agama_calon_istri=="Kristen")    
                        <td style="color:black;">Surat Baptis + Status Liber</td>
                        <td>@if(isset($d->surat_baptis_calon_suami))<a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->surat_baptis_calon_istri))<a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/surat_baptis/'.$d->surat_baptis_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami=="Katolik" || $d->agama_calon_istri=="Katolik")
                        <td style="color:black;">Sertifikat Komuni</td>
                        <td>@if(isset($d->sertifikat_komuni_calon_suami))<a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->sertifikat_komuni_calon_istri))<a href="#modalPopUp4{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_komuni/'.$d->sertifikat_komuni_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami=="Katolik" || $d->agama_calon_istri=="Katolik")
                        <td style="color:black;">Sertifikat Krisma</td>
                        <td>@if(isset($d->sertifikat_krisma_calon_suami))<a href="#modalPopUp5{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->sertifikat_krisma_calon_istri))<a href="#modalPopUp6{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/sertifikat_krisma/'.$d->sertifikat_krisma_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_lingkungan_calon_suami) || isset($d->suratpengantar_lingkungan_calon_istri))
                        <td style="color:black;">Surat Pengantar Lingkungan</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_suami))<a href="#modalPopUp7{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_istri))<a href="#modalPopUp8{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_paroki_calon_suami) || isset($d->suratpengantar_paroki_calon_istri))
                        <td style="color:black;">Surat Pengantar Paroki</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_suami))<a href="#modalPopUp9{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_istri))<a href="#modalPopUp10{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                        <td style="color:black;">NIK</td>
                        <td>{{$d->nik_calon_suami}}</td>
                        <td>{{$d->nik_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">KTP</td>
                        <td><a href="#modalPopUp11{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_suami)}}" height='80px'/></td>
                        <td><a href="#modalPopUp12{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/ktp/'.$d->ktp_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                        <td style="color:black;">KK</td>
                        <td><a href="#modalPopUp13{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_suami)}}" height='80px'/></td>
                        <td><a href="#modalPopUp14{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/kk/'.$d->kk_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami!="Katolik" || $d->agama_calon_istri!="Katolik")
                        <td style="color:black;">Surat Keterangan Bebas Menikah</td>
                        <td>@if(isset($d->suratketerangan_bebas_menikah_calon_suami))<a href="#modalPopUp15{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratketerangan_bebas_menikah_calon_istri))<a href="#modalPopUp16{{$d->id}}" data-toggle="modal"><img src="{{asset('file_perkawinan/suratketerangan_bebas_menikah/'.$d->suratketerangan_bebas_menikah_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if($d->agama_calon_suami!="Katolik" || $d->agama_calon_istri!="Katolik")
                        <td style="color:black;">Surat Pernyataan Pihak Non-Katolik</td>
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
                    <tr style="text-align: center; color:black;">
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
                            <td style="color:black;">{{tanggal_indonesia($d->tanggal_kanonik)}}</td>
                        </tr>
                    </tbody>
                </thead>
            </table>
            <br><h6 style="color:black;"><b>Permohonan Tempat,Tanggal, Waktu Pelaksanaan Perkawinan:</b> {{$data[0]->tempat_perkawinan}}, {{tanggal_indonesia($data[0]->tanggal_perkawinan)}}, {{waktu_indonesia($data[0]->tanggal_perkawinan)}} WITA</h6><br>
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
        </div>
    </div>
</div>

@endsection

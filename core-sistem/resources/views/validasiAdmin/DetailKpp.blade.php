@extends('layouts.sbadmin2')

@section('title')
    Detail Formulir Pendaftaran Kursus Persiapan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">Detail Formulir Pendaftaran Kursus Persiapan Perkawinan</h1>

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
        Detail Formulir Pendaftaran 
    </div>
    <div class="card-body">
        <div class="table-responsive">
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
                        <td><b>IDENTITAS ORANG TUA</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap Ayah</td>
                        <td>{{$d->nama_ayah_calon_suami}}</td>
                        <td>{{$d->nama_ayah_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap Ibu</td>
                        <td>{{$d->nama_ibu_calon_suami}}</td>
                        <td>{{$d->nama_ibu_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td><b>LAMPIRAN PRIBADI</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td>KTP</td>
                        <td><img src="{{asset('file_kpp/ktp/'.$d->ktp_calon_suami)}}" height='80px'/></td>
                        <td><img src="{{asset('file_kpp/ktp/'.$d->ktp_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                        <td>Surat Pengantar Lingkungan</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_suami))<img src="{{asset('file_kpp/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_istri))<img src="{{asset('file_kpp/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_istri)}}" height='80px'/>@endif</td>
                    </tr>
                    <tr>
                        <td>Surat Pengantar Paroki</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_suami))<img src="{{asset('file_kpp/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_istri))<img src="{{asset('file_kpp/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_istri)}}" height='80px'/>@endif</td>
                    </tr>
                </tbody>
            </table>
            <br><h6><b>Tempat & Keterangan KPP:</b> {{$data[0]->lokasi}}, {{$data[0]->keterangan_kursus}}</h6>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="d-flex justify-content-end">
                    <form action="/validasiAdmin/declinekpp" class="ml-2" method="post">
                        @csrf
                        <input type="text" name="id" class="d-none" value="{{$d->id}}">
                        <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-danger">Tolak</a>
                    </form>
                    <form action="/validasiAdmin/acceptkpp" class="ml-2" method="post">
                        @csrf
                        <input type="text" name="id" class="d-none" value="{{$d->id}}">
                        <input type="text" name="keterangan_kursus" class="d-none" value="{{$d->keterangan_kursus}}">
                        <button class="btn btn-success" type="submit">Terima</button>
                    </form>
				</div>
			</div><br>
            <!-- EDIT WITH MODAL -->
            <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <form role="form" method="POST" action="{{ url('validasiAdmin/declinekpp') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Penolakan Pendaftaran KPP</h4>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <label>Alasan Penolakan:</label>
                                <input type="hidden" name="id" value="{{$d->id}}">
                                <input type="text" name="keterangan_kursus" class="d-none" value="{{$d->keterangan_kursus}}">
                                <textarea name="alasan_penolakan" class="form-control" id="" cols="30" rows="10" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
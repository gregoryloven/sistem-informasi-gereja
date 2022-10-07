@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
    #myTable3 td {text-align: center; vertical-align: middle;}
    #myTable4 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi Krisma
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi Krisma</h1>
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
        Daftar Permohonan Krisma Paroki Setempat
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Penerima</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Orang Tua Ayah</th>
                        <th>Orang Tua Ibu</th>
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasi as $d)
                    @php $i += 1; @endphp
                    <tr style="text-align: center;">
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->tempat_lahir}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                        <td st>{{$d->orangtua_ayah}}</td>
                        <td st>{{$d->orangtua_ibu}}</td>
                        <td st>{{$d->lingkungan}}</td>
                        <td st>{{$d->kbg}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/></a></td>
                        <td st><a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/></a></td>
                        <td >
                            @if($d->status == "Disetujui Lingkungan")
                            <form action="/validasiAdmin/acceptkrismasetempat" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <input type="text" name="jadwal" class="d-none" value="{{$d->jadwal}}">
                                <button class="btn btn-success" type="submit">Terima</button>
                            </form>
                            <form action="/validasiAdmin/declinekrismasetempat" class="ml-2" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-danger">Tolak</a>
                            </form>
                            @endif
                        </td>
                    </tr>
                    <!-- EDIT WITH MODAL -->
                    <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" >
                                <form role="form" method="POST" action="{{ url('validasiAdmin/declinekrismasetempat') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h5 class="modal-title">Penolakan Pendaftaran Krisma Paroki Setempat</h5>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <label>Alasan Penolakan:</label>
                                        <input type="hidden" name="id" value="{{$d->id}}">
                                        <input type="text" name="jadwal" class="d-none" value="{{$d->jadwal}}">
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
                    <!-- POP UP WITH MODAL -->
                    <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}">
                                </div>
                            </div>
                        </div>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp2{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Permohonan Krisma Lintas Paroki
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Penerima</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Orang Tua Ayah</th>
                        <th>Orang Tua Ibu</th>
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th>Surat Pengantar</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasi2 as $d)
                    @php $i += 1; @endphp
                    <tr style="text-align: center;">
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->tempat_lahir}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                        <td st>{{$d->orangtua_ayah}}</td>
                        <td st>{{$d->orangtua_ibu}}</td>
                        <td st>{{$d->lingkungan}}</td>
                        <td st>{{$d->kbg}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/></a></td>
                        <td st><a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/></a></td>
                        <td st><a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_pengantar/'.$d->surat_pengantar)}}" height='80px'/></a></td>
                        <td >
                            @if($d->status == "Diproses")
                            <form action="/validasiAdmin/acceptkrismalintas" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <input type="text" name="jadwal" class="d-none" value="{{$d->jadwal}}">
                                <button class="btn btn-success" type="submit">Terima</button>
                            </form>
                            <form action="/validasiAdmin/declinekrismalintas" class="ml-2" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-danger">Tolak</a>
                            </form>
                            @endif
                        </td>
                    </tr>
                    <!-- EDIT WITH MODAL -->
                    <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" >
                                <form role="form" method="POST" action="{{ url('validasiAdmin/declinekrismalintas') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h5 class="modal-title">Penolakan Pendaftaran Krisma Lintas Paroki</h5>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <label>Alasan Penolakan:</label>
                                        <input type="hidden" name="id" value="{{$d->id}}">
                                        <input type="text" name="jadwal" class="d-none" value="{{$d->jadwal}}">
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
                    <!-- POP UP WITH MODAL -->
                    <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog" style="width:400px; height=400px;">
                            <div class="modal-content" >
                                <img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}">
                            </div>
                        </div>
                    </div>
                    <!-- POP UP WITH MODAL -->
                    <div class="modal fade" id="modalPopUp2{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog" style="width:400px; height=400px;">
                            <div class="modal-content" >
                                <img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}">
                            </div>
                        </div>
                    </div>
                    <!-- POP UP WITH MODAL -->
                    <div class="modal fade" id="modalPopUp3{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog" style="width:400px; height=400px;">
                            <div class="modal-content" >
                                <img src="{{asset('file_sertifikat/surat_pengantar/'.$d->surat_pengantar)}}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
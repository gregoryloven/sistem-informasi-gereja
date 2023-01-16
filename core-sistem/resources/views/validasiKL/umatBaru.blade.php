@extends('layouts.sbkl')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi Pendaftaran Umat Baru
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi Pendaftaran Umat Baru - Lingkungan {{$lingkungan2}}</h1>
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
        Daftar Validasi Umat Baru
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
                        <th>Telepon</th>
                        <th>Foto Tanda Pengenal</th>
                        <th>Nomor Kartu Keluarga</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
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
                        <td st>{{$d->telepon}}</td>
                        <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('tanda_pengenal/'.$d->foto_ktp)}}" height='80px'/></td>
                        <td st>{{$d->no_kk}}</td>
                        <td st>
                            @if($d->status == "Disetujui KBG")
                            <form action="/validasiKL/acceptumatbaru" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <input type="text" name="lingkungan_id" class="d-none" value="{{$d->lingkungan_id}}">
                                <input type="text" name="kbg_id" class="d-none" value="{{$d->kbg_id}}">
                                <input type="text" name="userid" class="d-none" value="{{$d->userid}}">
                                <button class="btn btn-success" type="submit">Terima</button>
                            </form>
                            <form action="/validasiKL/declineumatbaru" class="mt-1" method="post">
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
                                <form role="form" method="POST" action="{{ url('validasiKL/declineumatbaru') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Penolakan Validasi</h4>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <label>Alasan Penolakan:</label>
                                        <input type="hidden" name="id" value="{{$d->id}}">
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
                                <img src="{{asset('tanda_pengenal/'.$d->foto_ktp)}}">
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
        Riwayat Validasi Umat Baru
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Hubungan Darah</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Foto Tanda Pengenal</th>
                        <th>Nomor Kartu Keluarga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($umatbaru2 as $da)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$da->nama_lengkap}}</td>
                        <td st>{{$da->hubungan}}</td>
                        <td st>{{$da->jenis_kelamin}}</td>
                        <td st>{{$da->telepon}}</td>
                        <td st><a href="#modalPopUp{{$da->id}}" data-toggle="modal"><img src="{{asset('tanda_pengenal/'.$da->foto_ktp)}}" height='80px'/></td>
                        <td st>{{$da->no_kk}}</td>
                        <td st >
                            @if($da->status == 'Disetujui Lingkungan') 
                            <div class="alert alert-success" role="alert">
                                {{$da->status}}
                            </div>
                            <small><b>Pada:</b> {{tanggal_indonesia($da->updated_at)}}, {{waktu_indonesia($da->updated_at)}} WITA</small>
                            @else
                            <div class="alert alert-danger" role="alert">
                                {{$da->status}}
                            </div>
                            <small><b>Pada:</b> {{tanggal_indonesia($da->updated_at)}}, {{waktu_indonesia($da->updated_at)}} WITA
                                <br><b>Alasan:</b> {{$da->alasan_penolakan}}</small>
                            @endif
                        </td>
                    </tr>
                    <!-- POP UP WITH MODAL -->
                    <div class="modal fade" id="modalPopUp{{$da->id}}" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog" style="width:400px; height=400px;">
                            <div class="modal-content" >
                                <img src="{{asset('tanda_pengenal/'.$da->foto_ktp)}}">
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
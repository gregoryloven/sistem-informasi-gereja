@extends('layouts.sbkl')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi</h1>
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
        Daftar Permohonan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Penerima</th>
                        <th>Wali Baptis Ayah</th>
                        <th>Wali Baptis Ibu</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Romo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasi as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->User->nama_user}}</td>
                        <td st>{{$d->Wali_baptis_ayah->nama_user}}</td>
                        <td st>{{$d->Wali_baptis_ibu->nama_user}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->jenis}}</td>
                        <td st>{{$d->romo}}</td>
                        <td st>
                            @if($d->status == "Disetujui KBG")
                            <form action="/validasiKL/acceptbaptis" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <button class="btn btn-success" type="submit">Terima</button>
                            </form>
                            <form action="/validasiKL/declinebaptis" class="ml-2" method="post">
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
                                <form role="form" method="POST" action="{{ url('validasiKL/declinebaptis') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Pembatalan Reservasi</h4>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Penerima</th>
                        <th>Wali Baptis Ayah</th>
                        <th>Wali Baptis Ibu</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Romo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasiAll as $da)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$da->User->nama_user}}</td>
                        <td st>{{$da->Wali_baptis_ayah->nama_user}}</td>
                        <td st>{{$da->Wali_baptis_ibu->nama_user}}</td>
                        <td st>{{tanggal_indonesia( $da->jadwal)}}</td>
                        <td st>{{waktu_indonesia( $da->jadwal)}}</td>
                        <td st>{{$da->lokasi}}</td>
                        <td st>{{$da->jenis}}</td>
                        <td st>{{$da->romo}}</td>
                        <td st >
                            @if($da->status == "Disetujui Lingkungan")
                            <div class="alert alert-success" role="alert">
                                {{$da->status}}
                            </div>
                            @elseif($da->status == "Ditolak")
                            <div class="alert alert-danger" role="alert">
                                {{$da->status}}
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
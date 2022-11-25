@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Sakramen Baptis Dewasa
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Penerima Sakramen Baptis Dewasa</h1>
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
        Sesi yang Tersedia 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Tanggal Buka Pendaftaran</th>
                        <th>Tanggal Tutup Pendaftaran</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{tanggal_indonesia($d->tgl_buka_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_tutup_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href= "{{ url('baptisdewasa/OpenForm/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Formulir Pendaftaran</a>   
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card shadow">
        <div class="card-header py-3">
            Riwayat Pendaftaran Sakramen Baptis
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable2">
                    <thead>
                        <tr style="text-align: center;">
                        <th width="5%">No</th>
                            <th>Nama Lengkap Penerima Baptis</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Orang Tua Ayah</th>
                            <th>Orang Tua Ibu</th>
                            <th>Wali Baptis Ayah</th>
                            <th>Wali Baptis Ibu</th>
                            <th>Lingkungan</th>
                            <th>KBG</th>
                            <th>Telepon</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>Lokasi</th>
                            <th>Romo</th>
                            <th>Surat Pernyataan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($baptis as $d)
                        @php $i += 1; @endphp
                        <tr>
                            <td>@php echo $i; @endphp</td>
                            <td st>{{$d->nama_lengkap}}</td>
                            <td st>{{$d->tempat_lahir}}</td>
                            <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                            <td st>{{$d->orangtua_ayah}}</td>
                            <td st>{{$d->orangtua_ibu}}</td>
                            <td st>{{$d->wali_baptis_ayah}}</td>
                            <td st>{{$d->wali_baptis_ibu}}</td>
                            <td st>{{$d->lingkungan}}</td>
                            <td st>{{$d->kbg}}</td>
                            <td st>{{$d->telepon}}</td>
                            <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                            <td st>{{waktu_indonesia( $d->jadwal)}} WITA</td>
                            <td st>{{$d->lokasi}}</td>
                            <td st>{{$d->romo}}</td>
                            <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_pernyataan/'.$d->surat_pernyataan)}}" height='80px'/></td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                    <div class="alert alert-success" role="alert">
                                        {{$d->status}}
                                    </div>
                                    <small><b>Pada:</b> {{tanggal_indonesia($d->created_at)}}, {{waktu_indonesia($d->created_at)}}</small>
                                @endif
                            </td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form role="form" method="POST" action="{{ url('baptisdewasa/'.$d->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                        <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('Apakah anda yakin ingin membatalkan data ini?')) return false">Batal</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/surat_pernyataan/'.$d->surat_pernyataan)}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
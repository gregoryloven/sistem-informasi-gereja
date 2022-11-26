@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi Kursus Persiapan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi Kursus Persiapan Perkawinan</h1>
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
                        <th>Nama Lengkap Calon Suami</th>
                        <th>Nama Lengkap Calon Istri</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasi as $d)
                    @php $i += 1; @endphp
                    <tr style="text-align: center;">
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap_calon_suami}}</td>
                        <td st>{{$d->nama_lengkap_calon_istri}}</td>
                        <td st>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href= "{{ url('validasiAdminKpp/DetailKpp/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Lihat Detail</a>   
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
    <div class="card-header py-3">
        Riwayat Validasi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap Calon Suami</th>
                        <th>Nama Lengkap Calon Istri</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasiAll as $da)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$da->nama_lengkap_calon_suami}}</td>
                        <td st>{{$da->nama_lengkap_calon_istri}}</td>
                        <td st >
                            @if($da->statusRiwayat == 'Disetujui Paroki') 
                            <div class="alert alert-success" role="alert">
                                {{$da->statusRiwayat}}<br>
                                <small>{{tanggal_indonesia($da->created_at)}}, {{waktu_indonesia($da->created_at)}} WITA</small>
                            </div>
                            @if($da->kursus == 'Lulus')
                                <small><b>Lulus Kursus</b> - {{tanggal_indonesia($da->updated_at)}}<br>{{waktu_indonesia($da->updated_at)}} WITA</small>
                            @elseif($da->kursus == 'Tidak Lulus')
                                <small><b>Tidak Lulus Kursus</b> - {{tanggal_indonesia($da->updated_at)}}<br>{{waktu_indonesia($da->updated_at)}} WITA</small>
                            @endif
                            @elseif($da->statusRiwayat == 'Ditolak') 
                            <div class="alert alert-danger" role="alert">
                                {{$da->statusRiwayat}}
                            </div>
                            <small><b>Pada:</b> {{tanggal_indonesia($da->created_at)}}, {{waktu_indonesia($da->created_at)}} WITA
                                <br><b>Alasan:</b> {{$da->alasan_penolakan}}</small>
                            @endif
                        </td>
                        <td st>
                            @if($da->statusRiwayat == "Disetujui Paroki")
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div><a href= "{{ url('validasiAdminKpp/RiwayatKpp/'.$da->id) }}" class="btn btn-xs btn-flat btn-info">Detail</a></div>
                                <form role="form" method="POST" action="{{ url('validasiAdminKpp/PembatalanKpp/'.$da->id) }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$da->id}}">
                                    <input type="hidden" class="form-control" name="keterangan_kursus" value="{{$da->keterangan_kursus}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger ml-1" onclick="if(!confirm('Apakah anda yakin ingin membatalkan data ini?')) return false">Batal</button>
                                </form>
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
@endsection
@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Detail Laporan Penolakan & Pembatalan Sakramen Krisma
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Detail Laporan Penolakan & Pembatalan Sakramen Krisma</h1>
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
        Daftar Peserta
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Tanggal Krisma</th>
                        <th>Waktu</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{tanggal_indonesia($d->jadwal)}}</td>
                        <td st>{{waktu_indonesia($d->jadwal)}} WITA</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->jenis}}</td>
                        <td st>
                            @if(isset($d->alasan_penolakan))
                                <b>Ditolak</b>: {{$d->alasan_penolakan}}<br>
                                <b>Oleh</b>: {{$d->user->role}} 
                                @if($d->user->role == 'ketua kbg')
                                    ({{$d->user->kbg->nama_kbg}})
                                @elseif($d->user->role == 'ketua lingkungan')
                                    ({{$d->user->lingkungan->nama_lingkungan}})
                                @endif
                                <br><b>Pada</b>: {{tanggal_indonesia($d->updated_at)}} {{waktu_indonesia($d->updated_at)}} WITA
                            @elseif(isset($d->alasan_pembatalan))
                                <b>Dibatalkan</b>: {{$d->alasan_pembatalan}}<br>
                                <b>Oleh</b>: {{$d->user->role}}
                                @if($d->user->role == 'ketua kbg')
                                    ({{$d->user->kbg->nama_kbg}})
                                @elseif($d->user->role == 'ketua lingkungan')
                                    ({{$d->user->lingkungan->nama_lingkungan}})
                                @endif
                                <br><b>Pada</b>: {{tanggal_indonesia($d->updated_at)}} {{waktu_indonesia($d->updated_at)}} WITA
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
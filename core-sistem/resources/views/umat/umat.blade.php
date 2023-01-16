@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Daftar Umat
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Umat</h1>
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
        Daftar Umat
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
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>No KK</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->hubungan}}</td>
                        <td st>{{$d->jenis_kelamin}}</td>
                        <td st>{{$d->lingkungan->nama_lingkungan}}</td>
                        <td st>{{$d->kbg->nama_kbg}}</td>
                        <td st>{{$d->alamat}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>{{$d->no_kk}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@includeIf('umat.importexcelkbg')
@endsection
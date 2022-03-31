@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    User
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar User</h1>
@if (session('status'))
    <div class="alert alert-success alert-dismissible" style="display: none;">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible" style="display: none;">{{ session('error') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama}}</td>
                        <td st>{{$d->tempat_lahir}}</td>
                        <td st>{{$d->tanggal_lahir}}</td>
                        <td st>{{$d->agama}}</td>
                        <td st>{{$d->jenis_kelamin}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>{{$d->role}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
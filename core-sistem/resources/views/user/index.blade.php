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
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>ID Kepala Keluarga</th>
                        <th>Nama Umat</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Lingkungan</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($users as $user)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$user->keluarga_id}}</td>
                        <td st>{{$user->nama_user}}</td>
                        <td st>{{$user->tempat_lahir}}</td>
                        <td st>{{$user->tanggal_lahir}}</td>
                        <td st>{{$user->agama}}</td>
                        <td st>{{$user->jenis_kelamin}}</td>
                        <td st>{{$user->telepon}}</td>
                        <td st>{{$user->alamat}}</td>
                        <td st>{{$user->nama_lingkungan}}</td>
                        <td st>{{$user->role}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
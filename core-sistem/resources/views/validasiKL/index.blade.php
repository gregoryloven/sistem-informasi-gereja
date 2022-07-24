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
        Formulir Permohonan Misa
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Jenis Pelayanan</th>
                        <th>Tanggal Permohonan</th>
                        <th>Alamat</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($reservasi as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td st>{{$d->nama_pemohon}}</td>
                        <td st>{{$d->namaPelayanan}}</td>
                        <td st>{{$d->jadwal}}</td>
                        <td st>{{$d->alamat}}</td>
                        <td st>{{$d->keterangan}}</td>
                        <td st class="d-flex">
                            @if($d->status == "Diterima1")
                            <form action="/validateMisaKL/accept" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <button class="btn btn-success" type="submit">Terima</button>
                            </form>
                            <form action="/validateMisaKL/decline" class="ml-2" method="post">
                                @csrf
                                <input type="text" name="id" class="d-none" value="{{$d->id}}">
                                <button class="btn btn-danger" type="submit">Tolak</button>
                            </form>
                            @elseif($d->status == "Diterima")
                            <div class="alert alert-success" role="alert">
                                {{$d->status}}
                            </div>
                            @else
                            <div class="alert alert-danger" role="alert">
                                {{$d->status}}
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @php $i = 0; @endphp
                    @foreach($reservasiAll as $da)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$da->nama_pemohon}}</td>
                        <td st>{{$da->namaPelayanan}}</td>
                        <td st>{{$da->jadwal}}</td>
                        <td st>{{$da->alamat}}</td>
                        <td st>{{$da->keterangan}}</td>
                        <td st class="d-flex">
                            @if($da->status == "Diterima")
                            <div class="alert alert-success" role="alert">
                                {{$da->status}}
                            </div>
                            @else
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
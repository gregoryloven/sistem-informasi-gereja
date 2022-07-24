@extends('layouts.sbkbg')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Pemindahan KBG
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pemindahan KBG</h1>
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
                        <th>Nama User</th>
                        <th>Nama KBG</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_user}}</td>
                        <!-- <td st>{{$d->nama_kbg}}</td> -->
                        <form role="form" method="POST" action="{{ url('pemindahanKBG/UpdateForm') }}" enctype="multipart/form-data">
                            @csrf
                            <td>
                                <input type="text" name="id" hidden id="param" value="{{$d->id_keluarga}}">
                                <select name="kbg" id="" class="form-control">
                                    <option value="{{$d->id_kbg}}">{{$d->nama_kbg}}</option>
                                    @foreach($kbg as $row)
                                        <option value="{{$row->id}}">{{$row->nama_kbg}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-success" type="submit">
                                    Simpan
                                </button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
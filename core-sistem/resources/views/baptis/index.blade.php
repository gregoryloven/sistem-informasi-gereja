@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Sakramen Baptis
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Penerima Sakramen Baptis</h1>
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
<a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Baptis</a><br><br>

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="{{ url('baptiss') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Baptis</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label >User</label>
                        <select class="form-control" id='users_id' name='users_id'>
                        <option value="">Choose</option>
                        @foreach($users as $u)
                        @if($u->role == "umat")
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Wali Baptis Ayah</label>
                        <select class="form-control" id='wali_baptis_ayah' name='wali_baptis_ayah'>
                        <option value="">Choose</option>
                        @foreach($users as $u)
                        @if($u->role == "umat" && $u->jenis_kelamin == "Pria")
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Wali Baptis Ibu</label>
                        <select class="form-control" id='wali_baptis_ibu' name='wali_baptis_ibu'>
                        <option value="">Choose</option>
                        @foreach($users as $u)
                        @if($u->role == "umat" && $u->jenis_kelamin == "Wanita")
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Romo</label>
                        <select class="form-control" id='id_romo' name='id_romo'>
                        <option value="">Choose</option>
                        @foreach($users as $u)
                        @if($u->role == "romo")
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Paroki</label>
                        <select class="form-control" id='parokis_id' name='parokis_id'>
                        <option value="">Choose</option>
                        @foreach($paroki as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label >Jenis</label>
                            <input type="text" class="form-control" id='jenis' name='jenis' placeholder="Jenis" required>
                        </div>
                        <div class="form-group">
                            <label >Tanggal Pembaptisan</label>
                            <input type="date" class="form-control" id='tanggal_pembaptisan' name='tanggal_pembaptisan' placeholder="Tanggal Pembaptisan" required>
                        </div>
                        <div class="form-group">
                            <label >Status</label>
                            <input type="text" class="form-control" id='status' name='status' placeholder="Batasan Wilayah" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Penerima</th>
                        <th>Wali Baptis Ayah</th>
                        <th>Wali Baptis Ibu</th>
                        <th>Romo</th>
                        <th>Paroki</th>
                        <th>Jenis</th>
                        <th>Tanggal Baptis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        
                        <td st>{{$d->User->nama}}</td>
                        <td st>{{$d->Wali_baptis_ayah->nama}}</td>
                        <td st>{{$d->Wali_baptis_ibu->nama}}</td>
                        <td st>{{$d->Romo->nama}}</td>
                        <td st>{{$d->Paroki->nama}}</td>
                        <td st>{{$d->jenis}}</td>
                        <td st>{{$d->jadwal}}</td>
                        <td st>{{$d->status}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
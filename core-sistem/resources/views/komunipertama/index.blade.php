@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Sakramen Komuni Pertama
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Penerima Sakramen Komuni Pertama</h1>
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
<a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Komuni Pertama</a><br><br>

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="{{ url('komunipertamas') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Komuni Pertama</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label >User</label>
                        <select class="form-control" id='user_id' name='user_id'>
                        <option value="">Choose</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->nama_user }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Romo</label>
                        <select class="form-control" id='id_romo' name='id_romo'>
                        <option value="">Choose</option>
                        @foreach($romo as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_user }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Paroki</label>
                        <select class="form-control" id='paroki_id' name='paroki_id'>
                        <option value="">Choose</option>
                        @foreach($paroki as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_paroki }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label >Tanggal Komuni Pertama</label>
                            <input type="date" class="form-control" id='jadwal' name='jadwal' placeholder="Tanggal Komuni Pertama" required>
                        </div>
                    <div class="form-group">
                        <label >Status</label>
                        <select class="form-control" id='status' name='status'>
                        <option value="">Choose</option>
                        <option value="Belum Selesai">Belum Selesai</option>
                        <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <label>File Sertifikat</label>
                            <input type="file" value="" name="file_sertifikat" class="form-control" id="file_sertifikat" placeholder="File Sertifikat" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <img id="output" src="" width="200px" height="200px">
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
                        <th>Romo</th>
                        <th>Paroki</th>
                        <th>Tanggal Komuni Pertama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        
                        <td st>{{$d->User->nama_user}}</td>
                        <td st>{{$d->Romo->nama_user}}</td>
                        <td st>{{$d->Paroki->nama_paroki}}</td>
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
@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Daftar Ketua Lingkungan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Ketua Lingkungan</h1>
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
<a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Akun</a>
<a href="#modalAllKL" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Semua Akun</a><br><br>

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="/user/TambahKL" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Akun</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                    <div class="form-group">
                            <label >Username</label>
                            <input type="text" class="form-control" id='name' name='name' oninput='autogmail()' placeholder="Username" required>
                        </div>
                        <div class="form-group" style="width:60%">
                            <label >Email</label>
                            <input type="text" class="form-control" id='email' name='email' placeholder="Email" required>
                        </div>
                        <div><b>@gmail.com</b></div>
                        <div class="form-group">
                            <label >Password</label>
                            <input type="password" class="form-control" id='password' name='password' placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label >Lingkungan</label>
                            <select class="form-control" id='lingkungan_id' name='lingkungan_id'>
                                <option value="" disabled selected>Choose</option>
                                @foreach($ling as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lingkungan }}</option>
                                @endforeach
                            </select>
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

<!-- MODAL SEMUA KL -->
<div class="modal fade" id="modalAllKL" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form role="form" method="POST" action="/user/TambahAllKL" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Semua Akun</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <h4> APAKAH ANDA YAKIN MEMBUAT SEMUA AKUN KETUA LINGKUNGAN? <h4>
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

<!-- <div class="modal-footer">
                <a href="{{ url('user/TambahAllKL') }}" type="submit" class="btn btn-info">Submit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div> -->

<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Email</th>
                        <th>Lingkungan</th>
                        <th>Nama Lengkap</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($users as $u)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$u->email}}</td>
                        <td st>{{$u->Lingkungan->nama_lingkungan}}</td>
                        <td st>@if(isset($u->nama_lengkap)) {{$u->nama_lengkap}} @endif</td>
                       <td st> @if(isset($u->telepon)) {{$u->telepon}} @endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('javascript')
<script>
function autogmail()
{
    var name =$('#name').val()
    $('#email').val(name)
}
</script>
@endsection
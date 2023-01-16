@extends('layouts.sbkl')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Daftar Umat Lingkungan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Umat Lingkungan {{$lingkungan2}}</h1>
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

<div class="row">
    <div class="col-auto"><a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Umat</a></div>
    <div class="col-auto"><a href="#modalImportLingkungan" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-print"></i> Import Data</a><br><br></div>
</div>

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="/umat/TambahUmatLingkungan" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Umat</h4>
                </div>
                <div class="modal-body">
                    @csrf
                <div class="form-group">
                    <label >Nama Lengkap</label>
                    <input type="text" class="form-control" id='nama_lengkap' name='nama_lengkap' placeholder="Nama Lengkap" required>
                </div> 
                <div class="form-group">
                <label >Hubungan Darah</label>
                    <select class="form-control" id='hubungan_darah' name='hubungan_darah' required>
                        <option value="" disabled selected>Choose</option>
                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Jenis Kelamin</label>
                    <select class="form-control" id='jenis_kelamin' name='jenis_kelamin' required>
                        <option value="" disabled selected>Choose</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
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
                <div class="form-group">
                    <label >KBG</label>
                    <select class="form-control" id='kbg_id' name='kbg_id' required>
                    <option value="" disabled selected>Choose</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Alamat</label>
                    <input type="text" class="form-control" id='alamat' name='alamat' placeholder="Alamat" required>
                </div>
                <div class="form-group">
                    <label >Telepon</label>
                    <input type="text" class="form-control" id='telepon' name='telepon' placeholder="Telepon" required>
                </div>
                <div class="form-group">
                    <label >Nomor Kartu Keluarga</label>
                    <input type="number" class="form-control" id='no_kk' name='no_kk' placeholder="No KK" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" required>
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

<!-- EDIT WITH MODAL-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
            <div style="text-align: center;">
                <!-- <img src="{{ asset('res/loading.gif') }}"> -->
            </div>
        </div>
    </div>
</div>

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
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>No KK</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
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
                        <td st>{{$d->alamat}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>{{$d->lingkungan->nama_lingkungan}}</td>
                        <td st>{{$d->kbg->nama_kbg}}</td>
                        <td st>{{$d->no_kk}}</td>
                        <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditFormUmatLingkungan({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('umat/delete') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@includeIf('umat.importexcellingkungan')
@endsection

@section('javascript')
<script>
function EditFormUmatLingkungan(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('umat.EditFormUmatLingkungan', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContent').html(data.msg)
    }
  });
}

$('#lingkungan_id').change(function(){
    if($(this).val() != '') {
        var value = $(this).val();
        $.ajax({
            url:`{{ url('fetchkbgumat') }}`,
            method:"POST",
            data:{
                id:value, 
                _token: $('[name=csrf-token]').attr('content'), 
            },
            success:function(result) {
                // console.log(result);
                $('#kbg_id').html(result);
            }
        })
    }
});
</script>
@endsection
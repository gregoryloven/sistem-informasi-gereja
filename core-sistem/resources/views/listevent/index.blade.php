@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    List Events
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">List Events</h1>
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
<a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Event</a><br><br>

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="{{ url('listevents') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Event</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <label >Nama Event</label>
                            <input type="text" class="form-control" id='nama_event' name='nama_event' placeholder="Nama Event" required>
                        </div>
                        <div class="form-group">
                            <label >Jenis</label>
                            <select class="form-control" id='jenis_event' name='jenis_event'>
                                <option value="">Choose</option>
                                <option value="Baptis">Baptis</option>
                                <option value="Komuni Pertama">Komuni Pertama</option>
                                <option value="Krisma">Krisma</option>
                                <option value="Tobat">Tobat</option>
                                <option value="Misa">Misa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Jadwal</label>
                            <input type="date" class="form-control" id='jadwal' name='jadwal' placeholder="Jadwal" required>
                        </div>
                        <div class="form-group">
                            <label >Lokasi</label>
                            <input type="text" class="form-control" id='lokasi' name='lokasi' placeholder="Lokasi" required>
                        </div>
                        <div class="form-group">
                            <label >Romo</label>
                            <input type="text" class="form-control" id='romo' name='romo' placeholder="Romo" required>
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
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Event</th>
                        <th>Jenis Event</th>
                        <th>Jadwal</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_event}}</td>
                        <td st>{{$d->jenis_event}}</td>
                        <td st>{{$d->jadwal}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevents/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
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
@endsection

@section('javascript')
<script>
function EditForm(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('listevents.EditForm', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContent').html(data.msg)
    }
  });
}
</script>
@endsection
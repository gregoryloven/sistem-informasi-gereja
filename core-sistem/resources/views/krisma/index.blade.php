@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Sakramen Krisma
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Daftar Penerima Sakramen Krisma</h1>
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
<!-- EDIT WITH MODAL-->
<div class="modal fade" id="modalEdit2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContentt">
            <div style="text-align: center;">
                <!-- <img src="{{ asset('res/loading.gif') }}"> -->
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Sesi yang Tersedia 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Tanggal Buka Pendaftaran</th>
                        <th>Tanggal Tutup Pendaftaran</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
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
                        <td st>{{tanggal_indonesia($d->tgl_buka_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_tutup_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href= "{{ url('krisma/OpenForm/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Formulir Pendaftaran</a>   
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card shadow">
        <div class="card-header py-3">
            Riwayat Pendaftaran Sakramen Krisma Paroki Setempat
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable2">
                    <thead>
                        <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap Penerima Krisma</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Orang Tua Ayah</th>
                        <th>Orang Tua Ibu</th>
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($krisma as $d)
                        @php $i += 1; @endphp
                        <tr>
                            <td>@php echo $i; @endphp</td>
                            <td st>{{$d->nama_lengkap}}</td>
                            <td st>{{$d->tempat_lahir}}</td>
                            <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                            <td st>{{$d->orangtua_ayah}}</td>
                            <td st>{{$d->orangtua_ibu}}</td>
                            <td st>{{$d->lingkungan}}</td>
                            <td st>{{$d->kbg}}</td>
                            <td st>{{$d->telepon}}</td>
                            <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                            <td st>{{waktu_indonesia( $d->jadwal)}}</td>
                            <td st>{{$d->lokasi}}</td>
                            <td st>{{$d->romo}}</td>
                            <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/></a></td>
                            <td st><a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/></a></td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                    <div class="alert alert-success" role="alert">
                                        {{$d->status}}
                                    </div>
                                    <small><b>Pada:</b> {{tanggal_indonesia($d->created_at)}}, {{waktu_indonesia($d->created_at)}}</small>
                                @endif
                            </td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form role="form" method="POST" action="{{ url('krisma/'.$d->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                        <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('Apakah anda yakin ingin membatalkan data ini?')) return false">Batal</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}">
                                </div>
                            </div>
                        </div>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp2{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card shadow">
        <div class="card-header py-3">
            Riwayat Pendaftaran Sakramen Krisma Lintas Paroki
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable2">
                    <thead>
                        <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap Penerima Krisma</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Orang Tua Ayah</th>
                        <th>Orang Tua Ibu</th>
                        <th>Lingkungan</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th>Surat Pengantar Paroki</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($krisma2 as $d)
                        @php $i += 1; @endphp
                        <tr>
                            <td>@php echo $i; @endphp</td>
                            <td st>{{$d->nama_lengkap}}</td>
                            <td st>{{$d->tempat_lahir}}</td>
                            <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                            <td st>{{$d->orangtua_ayah}}</td>
                            <td st>{{$d->orangtua_ibu}}</td>
                            <td st>{{$d->lingkungan}}</td>
                            <td st>{{$d->kbg}}</td>
                            <td st>{{$d->telepon}}</td>
                            <td st>{{tanggal_indonesia( $d->jadwal)}}</td>
                            <td st>{{waktu_indonesia( $d->jadwal)}}</td>
                            <td st>{{$d->lokasi}}</td>
                            <td st>{{$d->romo}}</td>
                            <td st><a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/></a></td>
                            <td st><a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/></a></td>
                            <td st><a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_pengantar/'.$d->surat_pengantar)}}" height='80px'/></a></td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                    <div class="alert alert-success" role="alert">
                                        {{$d->status}}
                                    </div>
                                    <small><b>Pada:</b> {{tanggal_indonesia($d->created_at)}}, {{waktu_indonesia($d->created_at)}}</small>
                                @endif
                            </td>
                            <td st>
                                @if($d->status == "Disetujui Paroki")
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form role="form" method="POST" action="{{ url('krisma/'.$d->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                        <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('Apakah anda yakin ingin membatalkan data ini?')) return false">Batal</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}">
                                </div>
                            </div>
                        </div>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp2{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}">
                                </div>
                            </div>
                        </div>
                        <!-- POP UP WITH MODAL -->
                        <div class="modal fade" id="modalPopUp3{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog" style="width:400px; height=400px;">
                                <div class="modal-content" >
                                    <img src="{{asset('file_sertifikat/surat_pengantar/'.$d->surat_pengantar)}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
function EditForm(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('krisma.EditForm', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContent').html(data.msg)
    }
  });
}
function EditForm2(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('krisma.EditForm2', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContentt').html(data.msg)
    }
  });
}
</script>
@endsection
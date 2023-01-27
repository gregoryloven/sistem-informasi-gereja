@extends('layouts.sbkl')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi Pendaftaran Umat
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi Pendaftaran Umat - Lingkungan {{$lingkungan2}}</h1>
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
        Daftar Validasi Umat
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Hubungan</th>
                        <th>No KK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th>Sertifikat Krisma</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($umat as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->hubungan}}</td>
                        <td st>{{$d->no_kk}}</td>
                        <td st>{{$d->jenis_kelamin}}</td>
                        <td st>{{$d->tempat_lahir}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                        <td st>{{$d->kbg->nama_kbg}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>@if(isset($d->surat_baptis))<a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>@if(isset($d->sertifikat_komuni))<a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>@if(isset($d->sertifikat_krisma))<a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_krisma/'.$d->sertifikat_krisma)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>
                            @if($d->status == 'Belum Tervalidasi')
                            <small><div class="alert alert-warning" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @elseif($d->status == 'Ditolak')
                            <small><div class="alert alert-danger" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @elseif($d->status == 'Tervalidasi')
                            <small><div class="alert alert-success" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @endif

                            @if($d->status_baptis == '')
                            <small><div class="alert alert-warning" role="alert">
                                Baptis: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Baptis: Sudah
                            </div></small>
                            @endif

                            @if($d->status_komuni == '')
                            <small><div class="alert alert-warning" role="alert">
                                Komuni: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Komuni: Sudah
                            </div></small>
                            @endif

                            @if($d->status_krisma == '')
                            <small><div class="alert alert-warning" role="alert">
                                Krisma: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Krisma: Sudah
                            </div></small>
                            @endif
                        </td>
                        <td st>
                            @if($d->status != 'Ditolak')
                            <div><a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-info" onclick="EditForm({{ $d->id }})">Detail</a></div>
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
                                <img src="{{asset('file_sertifikat/sertifikat_krisma/'.$d->sertifikat_krisma)}}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi Umat
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Hubungan</th>
                        <th>No KK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>KBG</th>
                        <th>Telepon</th>
                        <th>Surat Baptis</th>
                        <th>Sertifikat Komuni</th>
                        <th>Sertifikat Krisma</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($umat2 as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td st>{{$d->hubungan}}</td>
                        <td st>{{$d->no_kk}}</td>
                        <td st>{{$d->jenis_kelamin}}</td>
                        <td st>{{$d->tempat_lahir}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_lahir)}}</td>
                        <td st>{{$d->kbg->nama_kbg}}</td>
                        <td st>{{$d->telepon}}</td>
                        <td st>@if(isset($d->surat_baptis))<a href="#modalPopUp{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/surat_baptis/'.$d->surat_baptis)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>@if(isset($d->sertifikat_komuni))<a href="#modalPopUp2{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_komuni/'.$d->sertifikat_komuni)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>@if(isset($d->sertifikat_krisma))<a href="#modalPopUp3{{$d->id}}" data-toggle="modal"><img src="{{asset('file_sertifikat/sertifikat_krisma/'.$d->sertifikat_krisma)}}" height='80px'/>
                            @else -
                            @endif
                        </td>
                        <td st>
                            @if($d->status == 'Belum Tervalidasi')
                            <small><div class="alert alert-warning" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @elseif($d->status == 'Ditolak')
                            <small><div class="alert alert-danger" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @elseif($d->status == 'Tervalidasi')
                            <small><div class="alert alert-success" role="alert">
                                Lingkungan: {{$d->status}}
                            </div></small>
                            @endif

                            @if($d->status_baptis == '')
                            <small><div class="alert alert-warning" role="alert">
                                Baptis: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Baptis: Sudah
                            </div></small>
                            @endif

                            @if($d->status_komuni == '')
                            <small><div class="alert alert-warning" role="alert">
                                Komuni: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Komuni: Sudah
                            </div></small>
                            @endif

                            @if($d->status_krisma == '')
                            <small><div class="alert alert-warning" role="alert">
                                Krisma: -
                            </div></small>
                            @else
                            <small><div class="alert alert-success" role="alert">
                                Krisma: Sudah
                            </div></small>
                            @endif
                            
                        </td>
                        <td st>
                            @if($d->status != 'Ditolak')
                            <div><a href="#modalEdit2" data-toggle="modal" class="btn btn-xs btn-flat btn-info" onclick="EditForm2({{ $d->id }})">Ubah</a></div>
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
                                <img src="{{asset('file_sertifikat/sertifikat_krisma/'.$d->sertifikat_krisma)}}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
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
    url:'{{ route('validasiKL.EditForm', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id,
         },
    success: function(data){
      $('#modalContent').html(data.msg);
    }
  });
}

function EditForm2(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('validasiKL.EditFormRiwayat', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id,
         },
    success: function(data){
      $('#modalContentt').html(data.msg);

    if(data.data.status_baptis == 'Sudah Baptis')
      {
        $('#baptiss').attr('checked',true)
      }
      else if(data.data.status_baptis == null)
      {
        $('#baptiss').attr('checked',false)
      }
      if(data.data.status_komuni == 'Sudah Komuni')
      {
        $('#komunii').attr('checked',true)
      }
      else if(data.data.status_komuni == null)
      {
        $('#komunii').attr('checked',false)
      }
      if(data.data.status_krisma == 'Sudah Krisma')
      {
        $('#krismaa').attr('checked',true)
      }
      else if(data.data.status_krisma == null)
      {
        $('#krismaa').attr('checked',false)
      }

    }
  });
}
</script>
@endsection
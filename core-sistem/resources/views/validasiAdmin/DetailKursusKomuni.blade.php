@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Detail Peserta Kursus Komuni Pertama
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Detail Peserta Kursus Komuni Pertama</h1>

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

<div style="display:none" class="alert alert-success">
    Status Pendaftar Komuni Berhasil Diubah 
</div>


<br>
<button type="submit" class="btn btn-success btn-flat" id="button" onclick="CekLulus('lulus')">Lulus</button>
<button type="submit" class="btn btn-danger btn-flat" id="button" onclick="CekLulus('tidak lulus')">Tidak Lulus</button><br><br>
<input type="hidden" id="list_event_id" value="{{$id}}">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Peserta
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                <div class="form-group">
                    <input type="checkbox" id="checkall" name="checkall" onchange="checkall(this)">
                    <label>Check All</label>
                </div>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Nama Penerima Komuni</th>
                        <th>Status Kursus</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($komuni as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap}}</td>
                        <td>
                            @if($d->kursus == 'Lulus')
                            <div class="alert alert-success" role="alert">
                                Lulus
                            </div>
                            @elseif($d->kursus == 'Tidak Lulus')
                            <div class="alert alert-danger" role="alert">
                                Tidak Lulus
                            </div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="hidden" id="riwayatID_{{$d->id}}" value="{{$d->riwayatID}}">
                                <input type="hidden" id="user_id_penerima_{{$d->id}}" value="{{$d->user_id_penerima}}">
                                <input type="checkbox" id="lulus_{{$d->id}}" name="lulus">
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
    
function CekLulus(lulus)
{
    array = []

    $("input[name='lulus']:checked").each(function(){
        var id = $(this).attr('id').split('_')[1]        
        var cek = {'id':id, 'riwayatID':$('#riwayatID_'+id).val(), 'user_id_penerima':$('#user_id_penerima_'+id).val()}
        array.push(cek)
    })
    console.log(array)
    $.ajax({
    type:'POST',
    url:'{{ route('validasiAdmin.LulusKursusKomuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'data':array,
          'status':lulus,
          'id':$('#list_event_id').val(),
          'riwayatID':$('#riwayatID_').val(),
          'user_id_penerima':$('#user_id_penerima_').val()
         },
    success: function(data){
        window.location.reload()
        if(data.status == 'oke')
        {
            $('.alert-success').show()
        }       

    }
  });
}

function checkall()
{
    var cek = $('#checkall').is(':checked')

    if(cek == true)
    {
        $("input[name='lulus']").each(function()
        {
            $(this).prop('checked', true)
        })
    }
    else
    {
        $("input[name='lulus']").each(function()
        {
            $(this).prop('checked', false)
        })
    }
}
</script>
@endsection
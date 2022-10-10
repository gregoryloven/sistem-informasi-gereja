@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Validasi Komuni Pertama
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Validasi Komuni Pertama</h1>

<div style="display:none" class="alert alert-success">
    Status Pendaftar Komuni Berhasil Diubah
</div>


<br>
<button type="submit" class="btn btn-success btn-flat" id="button" onclick="CekLulus('lulus')">Lulus</button>
<button type="submit" class="btn btn-danger btn-flat" id="button" onclick="CekLulus('tidak lulus')">Tidak Lulus</button><br><br>
<input type="hidden" id="list_event_id" value="{{$id}}">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Permohonan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" style="text-align: center;">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Nama Penerima</th>
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
                            <div class="form-group">
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
        var cek = {'id':id}
        array.push(cek)
    })
    console.log(array)
    $.ajax({
    type:'POST',
    url:'{{ route('validasiAdmin.LulusKursusKomuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'data':array,
          'status':lulus,
          'id':$('#list_event_id').val()
         },
    success: function(data){
        if(data.status == 'oke')
        $('.alert-success').show()
    }
  });
}
// function CekLulus()
// {
//     array = []

//     $('input[type=checkbox]').each(function(){
//         var id = $(this).attr(id).split('_')[1]
//         var cek = {'id':id, 'value':$(this).is(':checked')}
//         array.push(cek)
//     })
//     $.ajax({
//     type:'POST',
//     url:'{{ route('validasiAdmin.LulusKursusKomuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
//     data:{
//           'data':array
//          },
//     success: function(data){
     
//     }
//   });
// }
</script>
@endsection
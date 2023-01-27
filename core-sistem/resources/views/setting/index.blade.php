@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
    #myTable3 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Pengaturan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pengaturan Administrasi Sakramen</h1>
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

@if(!isset($setting))
<a href="#modalCreate" data-toggle='modal' class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Buat Ketentuan</a><br><br>
@endif

<!-- CREATE WITH MODAL -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <form role="form" method="POST" action="{{ url('setting') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Buat Ketentuan</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <label >Jenis Sakramen</label>
                            <select class="form-control" id='jenis_sakramen' name='jenis_sakramen' onchange='checkJenisSakramen(this)' required>
                                <option value="" disabled selected>Choose</option>
                                <option value="Baptis">Baptis</option>
                                <option value="Komuni Pertama">Komuni Pertama</option>
                            </select>
                        </div>
                        <label style='display:none; color:red;' id='label_baptis'>*Ketentuan Baptis</label>
                        <div style='display:none' id='label_umur_baptis_bayi' class="form-group">
                            <label >Bayi & Anak: Umur kurang dari sama dengan (Tahun)</label>
                            <input type="number" class="form-control" id='umur_baptis_bayi' name='umur_baptis_bayi' oninput='autoumurdewasa()' min="1" required>
                        </div>
                        <div style='display:none' id='label_umur_baptis_dewasa' class="form-group">
                            <label >Dewasa: Umur lebih dari sama dengan (Tahun)</label>
                            <input type="number" class="form-control" id='umur_baptis_dewasa' name='umur_baptis_dewasa' oninput='autoumurbayi()' min="1" required>
                        </div>
                        <label style='display:none; color:red;' id='label_lampiran'>*Lampiran yang disertakan (optional)</label>
                        <div style='display:none' id='label_akta_kelahiran' class="form-group">
                            <label >Akta Kelahiran</label>
                            <input type="checkbox" id="akta_kelahiran" name="akta_kelahiran">
                        </div>
                        <div style='display:none' id='label_kartu_keluarga' class="form-group">
                            <label >Kartu Keluarga</label>
                            <input type="checkbox" id="kartu_keluarga" name="kartu_keluarga">
                        </div>
                        <label style='display:none; color:red;' id='label_komuni'>*Ketentuan Komuni Pertama</label>
                        <div style='display:none' id='label_umur_komuni' class="form-group">
                            <label >Komuni Pertama: Umur lebih dari (Tahun)</label>
                            <input type="number" class="form-control" id='umur_komuni' name='umur_komuni' min="1" required>
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
        Ketentuan Administrasi Penerima Baptis
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th>Bayi & Anak</th>
                        <th>Dewasa</th>
                        <th>Akta Kelahiran</th>
                        <th>Kartu Keluarga</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setting as $d)
                    <tr>
                        <td st>
                        @if(isset($d->umur_baptis))
                            <b><=</b> {{$d->umur_baptis}} Tahun 
                        @else
                            Belum Ada  
                        @endif
                        </td>
                        <td st>
                        @if(isset($d->umur_baptis))
                            <b>>=</b> {{$d->umur_baptis}} Tahun
                        @else
                            Belum Ada 
                        @endif
                        </td>
                        <td st>
                        @if($d->akta_kelahiran == 1) 
                            Wajib Dilampirkan
                        @else
                            Tidak Perlu Dilampirkan
                        @endif
                        </td>
                        <td st>
                        @if($d->kartu_keluarga == 1) 
                            Wajib Dilampirkan
                        @else
                            Tidak Perlu Dilampirkan
                        @endif
                        </td>
                        <td>
                        @if(isset($d->umur_baptis))
                            <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})">Ubah</a>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Ketentuan Administrasi Penerima Komuni Pertama
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
                <thead>
                    <tr style="text-align: center;">
                        <th>Umur</th>
                        <th>Lainnya</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setting as $d)
                    <tr>
                        <td st><b>>=</b> {{$d->umur_komuni}} Tahun</td>
                        <td st>
                            - Telah menerima sakramen baptis<br>
                            - Wajib melampirkan surat baptis<br>
                            - Wajib mengikuti kursus
                        </td>
                        <td>
                        @if(isset($d->umur_komuni))
                            <a href="#modalEdit2" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm2({{ $d->id }})">Ubah</a>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Ketentuan Administrasi Penerima Krisma
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center;">
                        <th>Ketentuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td st>
                            - Telah menerima sakramen baptis<br>
                            - Wajib melampirkan surat baptis<br>
                            - Wajib melampirkan sertifikat komuni pertama<br>
                            - Wajib melampirkan surat pengantar paroki asal (khusus paroki luar)<br>
                            - Wajib mengikuti kursus
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- /.container-fluid -->
@endsection

@section('javascript')
<script src='http://code.jquery.com/ui/1.11.0/jquery-ui.js'></script>
<script>

function EditForm(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('setting.EditForm', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContent').html(data.msg)

      if(data.data.akta_kelahiran == 1)
      {
        $('#akta_kelahirann').attr('checked',true)
      }
      else if(data.data.akta_kelahiran == null)
      {
        $('#akta_kelahirann').attr('checked',false)
      }
      if(data.data.kartu_keluarga == 1)
      {
        $('#kartu_keluargaa').attr('checked',true)
      }
      else if(data.data.kartu_keluarga == null)
      {
        $('#kartu_keluargaa').attr('checked',false)
      }
    }
  });
}

function EditForm2(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('setting.EditFormKomuni', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContentt').html(data.msg)
    }
  });
}

function autoumurbayi()
{
    var umur_dewasa =$('#umur_baptis_dewasa').val()
    $('#umur_baptis_bayi').val(umur_dewasa)
}

function autoumurdewasa()
{
    var umur_bayi =$('#umur_baptis_bayi').val()
    $('#umur_baptis_dewasa').val(umur_bayi)
}

//Edit Form
function autoumurbayii()
{
    var umur_dewasa =$('#umur_baptis_dewasaa').val()
    $('#umur_baptis_bayii').val(umur_dewasa)
}

function autoumurdewasaa()
{
    var umur_bayi =$('#umur_baptis_bayii').val()
    $('#umur_baptis_dewasaa').val(umur_bayi)
}

function checkJenisSakramen(jenis)
{
    if($(jenis).val() == 'Baptis')
    {
        $('#label_baptis').show()
        $('#label_umur_baptis_bayi').show()
        $('#label_umur_baptis_dewasa').show()
        $('#label_akta_kelahiran').show()
        $('#label_kartu_keluarga').show()
        $('#label_lampiran').show()
        $('#label_komuni').hide()
        $('#label_umur_komuni').hide()

        $('#umur_komuni').prop('required',false)
    }
    else
    {
        $('#label_komuni').show()
        $('#label_umur_komuni').show()
        $('#label_baptis').hide()
        $('#label_umur_baptis_bayi').hide()
        $('#label_umur_baptis_dewasa').hide()
        $('#label_akta_kelahiran').hide()
        $('#label_kartu_keluarga').hide()
        $('#label_lampiran').hide()

        $('#umur_baptis_bayi').prop('required',false)
        $('#umur_baptis_dewasa').prop('required',false)
        $('#akta_kelahiran').prop('required',false)
        $('#kartu_keluarga').prop('required',false)
    }
}
</script>
@endsection

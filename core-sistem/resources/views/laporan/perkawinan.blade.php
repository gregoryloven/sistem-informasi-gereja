@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Laporan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Perkawinan</h1>
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

<!-- <form role="form" method="POST" action="/laporan/perkawinan">

    <div class="row">
    <div class="col-lg-12">
    <div class="box">
    @csrf
        <div class="col-sm-6">
            <div class="form-group">
            <label >Pilih Tahun</label>
                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                    <input type="text" id="datetimepicker3" name="datetimepicker3" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-xs btn-flat ">Pilih</button>
                </div>                
            </div>
        </div>
        <script type="text/javascript">
            $('#datetimepicker2').datetimepicker({
                viewMode : 'years',
                format : 'YYYY',
                toolbarPlacement: "top",
                allowInputToggle: true,
                icons: {
                        time: 'fa fa-time',
                        date: 'fa fa-calendar',
                        up: 'fa fa-chevron-up',
                        down: 'fa fa-chevron-down',
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-screenshot',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                        }                    
            });                         
        </script>
    </div>
</div>
</div>
</form> -->

<div class="card shadow mb-4" id="data1">
    <div class="card-header py-3">
        Daftar Peserta
    </div>    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Calon Suami</th>
                        <th>Calon Istri</th>
                        <th>Tanggal Perkawinan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp                                                  
                    @foreach($data as $d)
                    @php $i += 1; @endphp                    
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap_calon_suami}}</td>
                        <td st>{{$d->nama_lengkap_calon_istri}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_perkawinan)}} </td>
                    </tr>                                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4" id="data2">
    <div class="card-header py-3">
        Daftar Peserta
    </div>    
    @if(count($data2)!=0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Calon Suami</th>
                        <th>Calon Istri</th>
                        <th>Tanggal Perkawinan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp                                                  
                    @foreach($data2 as $d)
                    @php $i += 1; @endphp                    
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap_calon_suami}}</td>
                        <td st>{{$d->nama_lengkap_calon_istri}}</td>
                        <td st>{{tanggal_indonesia($d->tanggal_perkawinan)}} </td>
                    </tr>                                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<!-- /.container-fluid -->
@endsection

@section('javascript')
<script>
$(document).ready(function(){
            $('#data2').hide();
        });



</script>   
@endsection
@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
    #myTable3 td {text-align: center; vertical-align: middle;}
    #myTable4 td {text-align: center; vertical-align: middle;}
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

<!-- <a href= "{{ url('laporanPerkawinan/detaillingkungan') }}" class="btn btn-xs btn-flat btn-info">Lihat Detail Lingkungan</a><br><br> -->

<form role="form" method="GET" action="/laporan/perkawinan">
<div class="row">
    <div class="col-md-12">
        <div class="box">
    @csrf
        <div class="col-sm-12">
            <div class="form-group">
            <label >Pilih Tahun</label>
                <div class="row">
                    <div>
                        <select class="form-control" id='jenis' name='jenis' required>
                            <option value="" disabled selected>Choose</option>
                            <option value="1">Daftar Peserta</option>
                            <option value="2">Jumlah Per Lingkungan</option>
                            <option value="3">Rasio Agama</option>
                        </select>
                    </div>
                    <div class="input-group date col-sm-4" id="datetimepicker2" data-target-input="nearest">
                        <input type="text" id="datetimepicker3" name="datetimepicker3" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class=mt-1><b>-</b></div>                    
                    <div class="input-group date col-sm-5" id="datetimepicker5" data-target-input="nearest">
                        <input type="text" id="datetimepicker6" name="datetimepicker6" class="form-control datetimepicker-input" data-target="#datetimepicker5"/>
                        <div class="input-group-append" data-target="#datetimepicker5" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs btn-flat ml-2">Pilih</button>
                    </div>
                </div>                   
            </div>
        </div>                
        <script type="text/javascript">
            $('#datetimepicker2').datetimepicker({
                viewMode : 'years',
                format : 'MM-YYYY',
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
            $('#datetimepicker5').datetimepicker({
                viewMode : 'years',
                format : 'MM-YYYY',
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
</form>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Semua Peserta
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

@if(isset($data2))
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Peserta Tahun {{$s}} - {{$e}}
    </div>    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
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
</div>
@endif

@if(isset($data3))
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Jumlah Pendaftar Per Lingkungan ({{$s}} - {{$e}})
    </div>    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable3">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lingkungan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp                                                  
                    @foreach($data3 as $d)
                    @php $i += 1; @endphp                    
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lingkungan}}</td>
                        <td st>{{$d->jumlah_lingkungan}}</td>
                    </tr>                                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if(isset($abc))
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Rasio Agama Pernikahan (Bulan-Tahun) {{$s}} - {{$e}}
    </div>    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable4">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Katolik-Katolik</th>
                        <th>Katolik-Non Katolik</th>
                        <th>{{app('currentTenant')->name}}-{{app('currentTenant')->name}}</th>
                        <th>{{app('currentTenant')->name}}-Paroki Luar</th>
                        <th>Paroki Luar-Paroki Luar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp                                                  
                    @foreach($data4 as $d)
                    @php $i += 1; @endphp                    
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->jumlah_katolik_katolik}}</td>
                        <td st>{{$data5[0]->jumlah_katolik_nonkatolik}}</td>
                        <td st>{{$data6[0]->jumlah_sesama_paroki}}</td>
                        <td st>{{$data7[0]->jumlah_sesama_dan_paroki_luar}}</td>
                        <td st>{{$data8[0]->jumlah_sesama_paroki_luar}}</td>
                    </tr>                                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- /.container-fluid -->
@endsection
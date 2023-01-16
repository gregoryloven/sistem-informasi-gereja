@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Laporan Sakramen Baptis Bayi
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Sakramen Baptis Bayi</h1>
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

<form role="form" method="GET" action="/laporan/baptisbayi">
<div class="row">
    <div class="col-md-12">
        <div class="box">
    @csrf
        <div class="col-sm-12">
            <div class="form-group">
            <label >Pilih Tahun</label>
                <div class="row">
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
            $('#datetimepicker5').datetimepicker({
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
</form>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Semua Sesi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Tanggal Baptis</th>
                        <th>Waktu</th>
                        <th>Total Pendaftar</th>
                        <th>Total Pendaftar (Disetujui Paroki)</th>
                        <th>Total Pendaftar (Ditolak / Batal)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $idx => $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{tanggal_indonesia($d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia($d->jadwal_pelaksanaan)}} WITA</td>
                        <td st><strong>{{$array2[$idx]}} Orang</strong></td>
                        <td st><strong>{{$array[$idx]}} Orang</strong></td>
                        <td st><strong>{{$array3[$idx]}} Orang</strong>
                        @if($array3[$idx]!=0)
                            <br><a href= "{{ url('laporanBaptis/detail/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Lihat Detail</a>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(count($data2)!=0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Sesi Tahun {{$startDate}} - {{$endDate}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Tanggal Baptis</th>
                        <th>Waktu</th>
                        <th>Total Pendaftar</th>
                        <th>Total Pendaftar (Disetujui Paroki)</th>
                        <th>Total Pendaftar (Ditolak / Batal)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data2 as $idx => $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{tanggal_indonesia($d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia($d->jadwal_pelaksanaan)}} WITA</td>
                        <td st><strong>{{$array5[$idx]}} Orang</strong></td>
                        <td st><strong>{{$array4[$idx]}} Orang</strong></td>
                        <td st><strong>{{$array6[$idx]}} Orang</strong>
                        @if($array6[$idx]!=0)
                            <br><a href= "{{ url('laporanBaptis/detail/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Lihat Detail</a>
                        @endif
                        </td>
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
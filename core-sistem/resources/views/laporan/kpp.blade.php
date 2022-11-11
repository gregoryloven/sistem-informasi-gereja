@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Laporan Kursus Persiapan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Kursus Persiapan Perkawinan</h1>
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Daftar Sesi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>    
                        <th>Jenis Sakramen</th>
                        <th>Keterangan Kursus</th>
                        <th>Total Lulus Kursus</th>
                        <th>Total Tidak Lulus Kursus</th>
                        <!-- <th width="15%"><i class="fa fa-cog"></i></th> -->
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $idx => $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->jenis_event}}</td>
                        <td st>{{$d->keterangan_kursus}}</td>
                        <td st><strong>{{$array[$idx]}} Orang</strong></td>
                        <td st><strong>{{$array2[$idx]}} Orang</strong></td>
                        <!-- <td st>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href= "{{ url('laporanBaptis/DetailBaptis/'.$d->id) }}" class="btn btn-xs btn-flat btn-info">Lihat Detail</a>   
                            </div>
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
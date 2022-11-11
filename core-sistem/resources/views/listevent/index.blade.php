@extends('layouts.sbadmin2')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    #myTable2 td {text-align: center; vertical-align: middle;}
    #myTable3 td {text-align: center; vertical-align: middle;}
    #myTable4 td {text-align: center; vertical-align: middle;}
    #myTable5 td {text-align: center; vertical-align: middle;}
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
            <form role="form" method="POST" action="{{ url('listevent') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Event</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <label >Jenis Event</label>
                            <select class="form-control" id='jenis_event' name='jenis_event' onchange='checkJenisEvent(this)' required>
                                <option value="" disabled selected>Choose</option>
                                <option value="Baptis Bayi">Baptis Bayi</option>
                                <option value="Baptis Dewasa">Baptis Dewasa</option>
                                <option value="Komuni Pertama">Komuni Pertama</option>
                                <option value="Krisma">Krisma</option>
                                <option value="Tobat">Tobat</option>
                                <option value="Kursus Persiapan Perkawinan">Kursus Persiapan Perkawinan</option>
                                <option value="Misa">Misa</option>
                                <option value="Petugas Liturgi">Petugas Liturgi</option>
                            </select>
                        </div>
                        <div style='display:none' id='label_nama_event' class="form-group">
                            <label >Nama Event</label>
                            <input type="text" class="form-control" id='nama_event' name='nama_event' placeholder="Nama Event" required>
                        </div>
                        <div style='display:none' id='label_jenis_petugas' class="form-group">
                            <label>Jenis Petugas Liturgi</label>
                            <select class="form-control" name="petugas_liturgi_id" id="petugas_liturgi_id" required>
                                <option value="" disabled selected>Choose</option>
                                @foreach($petugas as $p)
                                <option value="{{$p->id}}">{{$p->jenis_petugas}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style='display:none' id='label_tanggal_buka' class="form-group">
                            <label >Tanggal Buka Pendaftaran</label>
                            <input type="date" class="form-control" id='tgl_buka_pendaftaran' name='tgl_buka_pendaftaran'  onchange='MinStartDate(this)' min="<?= date('Y-m-d'); ?>" placeholder="Tanggal Buka Pendaftaran" required>
                        </div>
                        <div style='display:none' id='label_tanggal_tutup' class="form-group">
                            <label >Tanggal Tutup Pendaftaran</label>
                            <input type="date" class="form-control" id='tgl_tutup_pendaftaran' name='tgl_tutup_pendaftaran'  onchange='CheckEndDate(this)' placeholder="Tanggal Tutup Pendaftaran" required>
                        </div>
                        <div style='display:none' id='label_jadwal_pelaksanaan' class="form-group">
                            <label >Jadwal Pelaksanaan</label>
                            <input type="datetime-local" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' onchange='CheckJadwalPelaksanaan(this)' min="<?= date('Y-m-d H:i:s'); ?>" placeholder="Jadwal Pelaksanaan" required>
                        </div>
                        <div style='display:none' id='label_lokasi' class="form-group">
                            <label >Lokasi</label>
                            <input type="text" class="form-control" id='lokasi' name='lokasi' placeholder="Lokasi" required>
                        </div>
                        <div style='display:none' id='label_kursus' class="form-group">
                            <label >Keterangan Kursus (Tempat, Tanggal, Waktu)</label>
                            <input type="text" class="form-control" id='keterangan_kursus' name='keterangan_kursus' placeholder="Keterangan Kursus" required>
                        </div>
                        <div style='display:none' id='label_romo' class="form-group">
                            <label >Romo</label>
                            <input type="text" class="form-control" id='romo' name='romo' placeholder="Romo" required>
                        </div>
                        <div style='display:none' id='label_kuota' class="form-group">
                            <label >Kuota</label>
                            <input type="number" class="form-control" id='kuota' name='kuota' placeholder="Kuota" min="1" required>
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
    <div class="card-header py-3">
        Sesi Sakramen Baptis, Komuni Pertama, Krisma
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Event</th>
                        <th>Jenis Event</th>
                        <th>Tanggal Buka Pendaftaran</th>
                        <th>Tanggal Tutup Pendaftaran</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Keterangan Kursus</th>
                        <th>Romo</th>
                        <th>Status</th>
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
                        <td st>{{tanggal_indonesia($d->tgl_buka_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_tutup_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->keterangan_kursus}}</td>
                        <td st>{{$d->romo}}</td>
                        <td st>
                            @if($d->status == 'Aktif')
                            <div class="alert alert-info" role="alert">{{$d->status}}</div>
                            @elseif($d->status == 'Selesai')
                            <div class="alert alert-success" role="alert">{{$d->status}}</div>
                            @else
                            <div class="alert alert-danger" role="alert">{{$d->status}}</div>
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 'Aktif')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                            </div>
                            @endif
                            <!-- <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a> <br>
                                @if ($d->status == 'Dibatalkan')
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='idbaptis' name='idbaptis' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                @elseif ($d->status == 'Selesai')
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                                @else
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='idbaptis' name='idbaptis' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                                @endif
                            </div> -->
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
        Sesi Kursus Persiapan Perkawinan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable4">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Event</th>
                        <th>Tanggal Buka Pendaftaran</th>
                        <th>Tanggal Tutup Pendaftaran</th>
                        <th>Lokasi</th>
                        <th>Keterangan Kursus</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data4 as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_event}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_buka_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_tutup_pendaftaran)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->keterangan_kursus}}</td>
                        <td st>
                            @if($d->status == 'Aktif')
                            <div class="alert alert-info" role="alert">{{$d->status}}</div>
                            @elseif($d->status == 'Selesai')
                            <div class="alert alert-success" role="alert">{{$d->status}}</div>
                            @else
                            <div class="alert alert-danger" role="alert">{{$d->status}}</div>
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 'Aktif')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='keterangan_kursus' name='keterangan_kursus' placeholder="Type your name" value="{{$d->keterangan_kursus}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                            </div>
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
        Sesi Sakramen Perkawinan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable5">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Lengkap Calon Suami</th>
                        <th>Nama Lengkap Calon Istri</th>
                        <th>Lokasi</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data5 as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_lengkap_calon_suami}}</td>
                        <td st>{{$d->nama_lengkap_calon_istri}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>
                            @if($d->status == 'Aktif' || $d->status == 'Pending')
                            <div class="alert alert-info" role="alert">{{$d->status}}</div>
                            @elseif($d->status == 'Selesai')
                            <div class="alert alert-success" role="alert">{{$d->status}}</div>
                            @else
                            <div class="alert alert-danger" role="alert">{{$d->status}}</div>
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 'Aktif')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                            </div>
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
        Sesi Misa & Tobat
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable2">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Event</th>
                        <th>Jenis Event</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Romo</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data2 as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_event}}</td>
                        <td st>{{$d->jenis_event}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st>{{$d->romo}}</td>
                        <td st>{{$d->kuota}}</td>
                        <td st>
                            @if($d->status == "Aktif")
                            <div class="alert alert-info" role="alert">
                                {{$d->status}}
                            </div>
                            @elseif($d->status == "Selesai")
                            <div class="alert alert-success" role="alert">
                                {{$d->status}}
                            </div>
                            @else
                            <div class="alert alert-danger" role="alert">
                                {{$d->status}}
                            </div>
                            @endif
                        </td>
                        <td>
                            @if ($d->status == 'Aktif')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                            </div>
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
        Sesi Petugas Liturgi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable3">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama Event</th>
                        <th>Jenis Event</th>
                        <th>Jenis Petugas Liturgi</th>
                        <th>Tanggal Buka Pendaftaran</th>
                        <th>Tanggal Tutup Pendaftaran</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data3 as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->nama_event}}</td>
                        <td st>{{$d->jenis_event}}</td>
                        <td st>{{$d->jenisPetugas}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_buka_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia($d->tgl_tutup_pendaftaran)}}</td>
                        <td st>{{tanggal_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{waktu_indonesia( $d->jadwal_pelaksanaan)}}</td>
                        <td st>{{$d->lokasi}}</td>
                        <td st><div class=" alert alert-success">{{$d->status}}</div></td>
                        <td>
                            @if ($d->status == 'Aktif')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                            </div>
                            @endif    
                            <!-- <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#modalEdit" data-toggle="modal" class="btn btn-xs btn-flat btn-warning" onclick="EditForm({{ $d->id }})"><i class="fa fa-pen"></i></a>
                                @if ($d->status == 'Dibatalkan')
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                @elseif ($d->status == 'Selesai')
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                                @else
                                <form role="form" method="POST" action="{{ url('listevent/'.$d->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i></button>
                                </form>
                                <form role="form" method="POST" action="{{ url('listevent/selesai') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$d->id}}">
                                    <input type="hidden" class="form-control" id='jadwal_pelaksanaan' name='jadwal_pelaksanaan' placeholder="Type your name" value="{{$d->jadwal_pelaksanaan}}">
                                    <button type="submit" class="btn btn-xs btn-flat btn-success" onclick="if(!confirm('apakah anda yakin ingin menyelesaikan event ini?')) return false"><i class="fa fa-check"></i></button>
                                </form>
                                @endif
                            </div> -->
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
<script src='http://code.jquery.com/ui/1.11.0/jquery-ui.js'></script>
<script>
//     $(document).ready(function(){
//     $('#label_nama_event').hide()
//     $('#label_tanggal_buka').hide()
//     $('#label_tanggal_tutup').hide()
//     $('#label_jadwal_pelaksanaan').hide()
//     $('#label_lokasi').hide()
//     $('#label_romo').hide()
//     $('#label_jenis_petugas').hide()
//     $('#label_kuota').hide()
// });

function EditForm(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('listevent.EditForm', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContent').html(data.msg)
    }
  });
}

function MinStartDate()
{
    $('#tgl_tutup_pendaftaran').attr('min', $('#tgl_buka_pendaftaran').val())
}

function CheckEndDate()
{
    if($('#tgl_buka_pendaftaran').val() == '')
    {   
        alert('Pilih Tanggal Buka Pendaftaran Terlebih Dahulu')
        $('#tgl_tutup_pendaftaran').val('')
        
    }
    var h1 = new Date($('#tgl_tutup_pendaftaran').val())
    h1.setDate(h1.getDate() + 1)
    // alert(h1.toISOString().substring(0,10))
    var enddate = h1.toISOString().substring(0,10) + ' 00:00:00' 
    $('#jadwal_pelaksanaan').attr('min', enddate)
}

function CheckJadwalPelaksanaan()
{
    if($('#tgl_buka_pendaftaran').val() == '' || $('#tgl_tutup_pendaftaran').val() == '')
    {   
        if($('#jenis_event').val() != 'Misa' && $('#jenis_event').val() != 'Tobat')
        {
            alert('Pilih Tanggal Buka dan Tutup Pendaftaran Terlebih Dahulu')
            $('#jadwal_pelaksanaan').val('')
        }
    }
}

function checkJenisEvent(jenis)
{

    if($(jenis).val() == 'Baptis Bayi' || $(jenis).val() == 'Baptis Dewasa')
    {
        $('#label_nama_event').show()
        $('#label_tanggal_buka').show()
        $('#label_tanggal_tutup').show()
        $('#label_jadwal_pelaksanaan').show()
        $('#label_lokasi').show()
        $('#label_romo').show()
        $('#label_jenis_petugas').hide()
        $('#label_kuota').hide()
        $('#label_kursus').hide()

        $('#petugas_liturgi_id').prop('required',false)
        $('#kuota').prop('required',false)
        $('#keterangan_kursus').prop('required',false)
    }
    else if($(jenis).val() == 'Komuni Pertama' || $(jenis).val() == 'Krisma')
    {
        $('#label_nama_event').show()
        $('#label_tanggal_buka').show()
        $('#label_tanggal_tutup').show()
        $('#label_jadwal_pelaksanaan').show()
        $('#label_lokasi').show()
        $('#label_kursus').show()
        $('#label_romo').show()
        $('#label_jenis_petugas').hide()
        $('#label_kuota').hide()

        $('#petugas_liturgi_id').prop('required',false)
        $('#kuota').prop('required',false)
    }
    else if($(jenis).val() == 'Tobat' || $(jenis).val() == 'Misa')
    {
        $('#label_nama_event').show()
        $('#label_jadwal_pelaksanaan').show()
        $('#label_lokasi').show()
        $('#label_romo').show()
        $('#label_kuota').show()
        $('#label_jenis_petugas').hide()
        $('#label_tanggal_buka').hide()
        $('#label_tanggal_tutup').hide()
        $('#label_kursus').hide()

        $('#petugas_liturgi_id').prop('required',false)
        $('#tgl_buka_pendaftaran').prop('required',false)
        $('#tgl_tutup_pendaftaran').prop('required',false)
        $('#keterangan_kursus').prop('required',false)
    }
    else if($(jenis).val() == 'Petugas Liturgi')
    {
        $('#label_nama_event').show()
        $('#label_tanggal_buka').show()
        $('#label_tanggal_tutup').show()
        $('#label_jadwal_pelaksanaan').show()
        $('#label_jenis_petugas').show()
        $('#label_lokasi').show()
        $('#label_romo').hide()
        $('#label_kuota').hide()
        $('#label_kursus').hide()

        $('#romo').prop('required',false)
        $('#kuota').prop('required',false)
        $('#keterangan_kursus').prop('required',false)
    }
    else
    {
        $('#label_nama_event').show()
        $('#label_tanggal_buka').show()
        $('#label_tanggal_tutup').show()
        $('#label_lokasi').show()
        $('#label_kursus').show()
        $('#label_jenis_petugas').hide()
        $('#label_jadwal_pelaksanaan').hide()
        $('#label_romo').hide()
        $('#label_kuota').hide()

        $('#petugas_liturgi_id').prop('required',false)
        $('#jadwal_pelaksanaan').prop('required',false)
        $('#romo').prop('required',false)
        $('#kuota').prop('required',false)
    }
}

//Untuk EditForm
function MinStartDatee()
{
    $('#tgl_tutup_pendaftarann').attr('min', $('#tgl_buka_pendaftarann').val())
}

function CheckEndDatee()
{
    if($('#tgl_buka_pendaftarann').val() == '')
    {   
        alert('Pilih Tanggal Buka Pendaftaran Terlebih Dahulu')
        $('#tgl_tutup_pendaftarann').val('')
        
    }
    var h1 = new Date($('#tgl_tutup_pendaftarann').val())
    h1.setDate(h1.getDate() + 1)
    // alert(h1.toISOString().substring(0,10))
    var enddate = h1.toISOString().substring(0,10) + ' 00:00:00' 
    $('#jadwal_pelaksanaann').attr('min', enddate)
}

function CheckJadwalPelaksanaann()
{
    if($('#tgl_buka_pendaftarann').val() == '' || $('#tgl_tutup_pendaftarann').val() == '')
    {   
        if($('#jenis_eventt').val() != 'Misa' && $('#jenis_eventt').val() != 'Tobat')
        {
            alert('Pilih Tanggal Buka dan Tutup Pendaftaran Terlebih Dahulu')
            $('#jadwal_pelaksanaann').val('')
        }
        
    }
}
</script>
@endsection

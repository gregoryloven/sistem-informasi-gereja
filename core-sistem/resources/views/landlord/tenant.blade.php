@extends('layouts.sbsuperadmin2')

@section('content')
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
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Domain</th>
                        <th>Database</th>
                        <th><i class="fa fa-cog">&nbsp; Aksi</i></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr>
                        <td>@php echo $i; @endphp</td>
                        <td>{{$d->nama_paroki}}</td>
                        <td>{{$d->alamat}}</td>
                        <td>{{$d->telepon}}</td>
                        <td>{{$d->domain}}</td>
                        <td>{{$d->database}}</td>
                        <td>
                            <a href="http://{{$d->domain}}:8000/" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-link"></i>&nbsp; Lihat Website</a>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form role="form" method="POST" action="{{ route('dashboards.deletetenant')}}"> &nbsp;
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" class="form-control" id='tenant_id' name='tenant_id' value="{{$d->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="if(!confirm('apakah anda yakin ingin menghapus data ini?')) return false"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
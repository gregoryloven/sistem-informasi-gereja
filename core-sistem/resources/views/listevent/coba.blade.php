<!-- <div class="card shadow mb-4">
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
</div> -->
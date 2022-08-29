<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th>Tanggal Aksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Diproses</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Diproses') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui KBG</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui KBG') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Lingkungan</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui Lingkungan') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Paroki</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui Paroki') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Selesai</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Selesai') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Ditolak</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Ditolak')  
                            <div class="alert alert-danger" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                            </div>
                            <small><b>Alasan: {{$l->alasan_penolakan}}<br>Oleh: {{$l->user->role}}</b></small>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Dibatalkan</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Dibatalkan') 
                            <div class="alert alert-danger" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}}
                                <br><small><b>Alasan: {{$l->alasan_pembatalan}}</b></small>
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
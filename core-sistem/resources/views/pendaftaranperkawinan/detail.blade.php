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
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Paroki</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui Paroki') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    @if($l->status=='Ditolak')
                    <tr><td>Ditolak</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Ditolak')  
                            <div class="alert alert-danger" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA
                            </div>
                            <small><b>Alasan: {{$l->alasan_penolakan}}<br>Oleh: {{$l->user->role}}</b></small>
                            @endif
                        @endforeach
                    </td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
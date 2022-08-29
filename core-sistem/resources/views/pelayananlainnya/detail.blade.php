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
                            @if($l['status']=='Diproses') 
                                {{tanggal_indonesia($l['created_at'])}}<br>{{waktu_indonesia($l['created_at'])}}
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui KBG</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l['status']=='Disetujui KBG') 
                                {{tanggal_indonesia($l['created_at'])}}<br>{{waktu_indonesia($l['created_at'])}}
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Lingkungan</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l['status']=='Disetujui Lingkungan') 
                                {{tanggal_indonesia($l['created_at'])}}<br>{{waktu_indonesia($l['created_at'])}}
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Paroki</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l['status']=='Disetujui Paroki') 
                                {{tanggal_indonesia($l['created_at'])}}<br>{{waktu_indonesia($l['created_at'])}}
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Selesai</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l['status']=='Disetujui Selesai') 
                                {{tanggal_indonesia($l['created_at'])}}<br>{{waktu_indonesia($l['created_at'])}}
                            @endif
                        @endforeach
                    </td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
 
 
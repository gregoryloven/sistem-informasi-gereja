<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th>Status</th>
                        <th>Tanggal Aksi</th>
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
                    <tr><td>Disetujui KBG</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui KBG') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA
                            </div>
                            @endif
                        @endforeach
                    </td></tr>
                    <tr><td>Disetujui Lingkungan</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Disetujui Lingkungan') 
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
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA<br>
                                <small><b>Keterangan Kursus:</b> {{$l->Ket}}</small>
                            </div>
                            @if($l->kursus == 'Lulus')
                                <small><b>Lulus Kursus</b> - {{tanggal_indonesia($l->updated_at)}}<br>{{waktu_indonesia($l->updated_at)}} WITA</small>
                            @elseif($l->kursus == 'Tidak Lulus')
                                <small><b>Tidak Lulus Kursus</b> - {{tanggal_indonesia($l->updated_at)}}<br>{{waktu_indonesia($l->updated_at)}} WITA</small>
                            @endif
                            @endif
                        @endforeach
                    </td></tr>
                    @if($l->status=='Selesai')
                    <tr><td>Selesai</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Selesai') 
                            <div class="alert alert-success" role="alert">
                                {{tanggal_indonesia($l->created_at)}}<br>{{waktu_indonesia($l->created_at)}} WITA
                            </div>
                            <small><b>PROFICIAT! </b>Silahkan mengambil sertifikat ke sekretariat paroki. Info lebih lanjut hubungi sekretariat paroki - {{tanggal_indonesia($l->updated_at)}}<br>{{waktu_indonesia($l->updated_at)}} WITA</small>
                            @endif
                        @endforeach
                    </td></tr>
                    @endif
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
                    @if($l->status=='Dibatalkan')
                    <tr><td>Dibatalkan</td>
                    <td>
                        @foreach($log as $l) 
                            @if($l->status=='Dibatalkan') 
                            <div class="alert alert-danger" role="alert">
                                {{tanggal_indonesia($l->updated_at)}}<br>{{waktu_indonesia($l->updated_at)}} WITA
                            </div>
                            <small><b>Alasan: {{$l->alasan_pembatalan}}<br>Oleh: {{$l->user->role}}</b></small>
                            @endif
                        @endforeach
                    </td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
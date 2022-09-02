@extends('layouts.sbuser')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
</style>
@endpush

@section('title')
    Permohonan Pelayanan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">
    <svg width="35" height="35" viewBox="0 0 145 145" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M142.797 67.2154C141.376 65.86 139.51 65.1658 137.546 65.257C136.76 65.2939 136.01 65.4612 135.313 65.7354V62.813C135.313 58.8904 132.122 55.6992 128.2 55.6992C124.277 55.6992 121.086 58.8904 121.086 62.813V65.8696C120.287 65.5586 119.42 65.3862 118.513 65.3862C114.59 65.3862 111.399 68.5773 111.399 72.5V77.9782C110.6 77.6673 109.733 77.4948 108.826 77.4948C104.903 77.4948 101.712 80.6859 101.712 84.6086V99.4102C90.8407 100.549 82.3384 109.767 82.3384 120.934V142.73C82.3384 143.984 83.3548 145 84.6088 145C85.8628 145 86.8793 143.984 86.8793 142.73V120.934C86.8793 111.504 94.5518 103.831 103.982 103.831H113.669C114.493 103.831 115.212 103.391 115.61 102.734L128.088 90.0679C128.57 89.5785 129.214 89.3061 129.901 89.3007C129.907 89.3007 129.914 89.3007 129.921 89.3007C130.601 89.3007 131.241 89.5629 131.726 90.0404C132.725 91.0245 132.737 92.6802 131.753 93.6793L118.902 106.726C118.092 107.547 118.037 108.888 118.776 109.773C119.623 110.789 121.209 110.854 122.136 109.912L134.988 96.8662C136.321 95.5125 137.048 93.7204 137.034 91.8203C137.021 90.1175 136.413 88.5117 135.313 87.237V72.5C135.313 71.0709 136.411 69.8565 137.759 69.7934C139.209 69.7212 140.46 70.9109 140.46 72.3632V98.1986L133.86 104.799C133.033 105.625 132.978 106.991 133.739 107.879C134.587 108.871 136.147 108.933 137.07 108.01L144.335 100.745C144.761 100.319 145 99.7418 145 99.1394V72.3637C145 70.4278 144.197 68.5515 142.797 67.2154ZM111.399 98.9874V99.2901H106.253V84.6086C106.253 83.1897 107.407 82.0354 108.826 82.0354C110.245 82.0354 111.399 83.1897 111.399 84.6086V98.9874H111.399ZM115.94 95.9291V72.5C115.94 71.0811 117.094 69.9268 118.513 69.9268C119.932 69.9268 121.086 71.0811 121.086 72.5V89.9059V90.5114C121.086 90.5737 121.09 90.6346 121.095 90.6955L115.94 95.9291ZM130.773 84.8159C130.492 84.7825 130.209 84.7598 129.922 84.7598C129.903 84.7598 129.885 84.7598 129.867 84.7601C128.314 84.7717 126.841 85.2775 125.627 86.2007V62.813C125.627 61.3941 126.781 60.2398 128.2 60.2398C129.619 60.2398 130.773 61.3941 130.773 62.813V84.8159H130.773Z" fill="black"/>
        <path d="M129.805 112.064C128.919 111.177 127.481 111.177 126.595 112.063L119.488 119.17L105.145 128.732C104.514 129.153 104.134 129.862 104.134 130.621V142.729C104.134 143.984 105.151 145 106.405 145C107.658 145 108.675 143.984 108.675 142.729V131.836L122.194 122.823C122.319 122.741 122.435 122.646 122.54 122.54L129.805 115.275C130.692 114.388 130.692 112.95 129.805 112.064Z" fill="black"/>
        <path d="M43.2884 99.4099V84.6083C43.2884 80.6857 40.0973 77.4945 36.1746 77.4945C35.2676 77.4945 34.4001 77.667 33.6015 77.9779V72.5C33.6015 68.5773 30.4103 65.3862 26.4877 65.3862C25.5806 65.3862 24.7131 65.5586 23.9145 65.8696V62.813C23.9145 58.8904 20.7234 55.6992 16.8007 55.6992C12.8781 55.6992 9.68696 58.8904 9.68696 62.813V65.7354C8.99028 65.4615 8.24064 65.2944 7.45475 65.257C5.49216 65.1695 3.62443 65.8597 2.20389 67.2154C0.803164 68.5515 0 70.4278 0 72.3632V77.3433C0 78.5973 1.01642 79.6137 2.27044 79.6137C3.52418 79.6137 4.54088 78.5976 4.54088 77.3433V72.3632C4.54088 70.9123 5.79122 69.7195 7.24122 69.7934C8.58983 69.8565 9.68724 71.0712 9.68724 72.5V87.2427C7.30239 90.0163 7.39981 94.2131 10.0124 96.8659L22.8641 109.912C23.7939 110.856 25.3747 110.786 26.2246 109.773C26.9657 108.889 26.9071 107.546 26.0989 106.725L13.2474 93.6793C12.2514 92.6683 12.2638 91.0359 13.2746 90.0404C14.2717 89.0577 15.933 89.0721 16.9134 90.0679L29.3908 102.734C29.789 103.391 30.5078 103.831 31.3316 103.831H41.0186C50.4492 103.831 58.1217 111.504 58.1217 120.934V142.729C58.1217 143.984 59.1382 145 60.3922 145C61.6459 145 62.6626 143.984 62.6626 142.729V120.934C62.6621 109.766 54.1597 100.548 43.2884 99.4099ZM19.3739 86.2007C18.1595 85.2775 16.6863 84.7717 15.1335 84.7601C14.8285 84.7573 14.5263 84.7762 14.2278 84.8116V62.813C14.2278 61.3941 15.3822 60.2398 16.801 60.2398C18.2199 60.2398 19.3742 61.3941 19.3742 62.813V86.2007H19.3739ZM29.0609 95.9288L23.9054 90.6952C23.9103 90.6346 23.9148 90.5734 23.9148 90.5114V72.5C23.9148 71.0811 25.0691 69.9268 26.488 69.9268C27.9068 69.9268 29.0612 71.0811 29.0612 72.5V95.9288H29.0609ZM38.7475 99.2901H33.6015V84.6086C33.6015 83.1897 34.7558 82.0354 36.1746 82.0354C37.5935 82.0354 38.7478 83.1897 38.7478 84.6086V99.2901H38.7475Z" fill="black"/>
        <path d="M39.8559 128.732L25.5128 119.17L4.54137 98.1987V89.4519C4.54137 88.1979 3.52495 87.1815 2.27093 87.1815C1.01719 87.1815 0.000488281 88.1976 0.000488281 89.4519V99.1389C0.000488281 99.741 0.239512 100.318 0.665449 100.744L22.4608 122.54C22.5664 122.645 22.6822 122.74 22.8068 122.823L36.3261 131.836V142.729C36.3261 143.984 37.3425 145 38.5965 145C39.8505 145 40.867 143.984 40.867 142.729V130.621C40.867 129.862 40.4875 129.153 39.8559 128.732Z" fill="black"/>
        <path d="M94.2954 33.9039H79.6139V14.3788C79.6139 13.1248 78.5975 12.1083 77.3434 12.1083H67.6565C66.4027 12.1083 65.386 13.1245 65.386 14.3788V33.9039H50.7045C49.4508 33.9039 48.4341 34.9201 48.4341 36.1744V45.8613C48.4341 47.1153 49.4505 48.1318 50.7045 48.1318H65.386V91.8739C65.386 93.1279 66.4025 94.1443 67.6565 94.1443H77.3434C78.5972 94.1443 79.6139 93.1282 79.6139 91.8739V48.1315H94.2954C95.5491 48.1315 96.5658 47.1153 96.5658 45.861V36.1741C96.5658 34.9201 95.5494 33.9039 94.2954 33.9039ZM92.0253 43.5909H77.3437C76.09 43.5909 75.0733 44.607 75.0733 45.8613V89.6034H69.9272V45.861C69.9272 44.607 68.9108 43.5906 67.6568 43.5906H52.9752V38.4445H67.6568C68.9105 38.4445 69.9272 37.4284 69.9272 36.1741V16.6492H75.0733V36.1744C75.0733 37.4284 76.0897 38.4448 77.3437 38.4448H92.0253V43.5909Z" fill="black"/>
        <path d="M72.5004 0C71.2467 0 70.23 1.01613 70.23 2.27044V7.11378C70.23 8.3678 71.2464 9.38421 72.5004 9.38421C73.7544 9.38421 74.7709 8.36808 74.7709 7.11378V2.27044C74.7709 1.01613 73.7542 0 72.5004 0Z" fill="black"/>
        <path d="M57.515 10.5207L55.0933 6.3262C54.466 5.24012 53.0775 4.86856 51.9919 5.49528C50.9061 6.1223 50.534 7.51084 51.161 8.59664L53.5824 12.7912C54.2496 13.9469 55.8189 14.2757 56.8959 13.4836C57.8152 12.8073 58.0848 11.5082 57.515 10.5207Z" fill="black"/>
        <path d="M44.2738 22.0995L40.0793 19.6778C38.9932 19.0508 37.6049 19.4226 36.9779 20.5087C36.3509 21.5948 36.723 22.9833 37.8088 23.6103L42.0034 26.032C43.1619 26.7004 44.6833 26.1971 45.2191 24.9748C45.6776 23.9295 45.2613 22.6695 44.2738 22.0995Z" fill="black"/>
        <path d="M38.5962 38.7473H33.7529C32.4991 38.7473 31.4824 39.7634 31.4824 41.0177C31.4824 42.2717 32.4988 43.2881 33.7529 43.2881H38.5962C39.8499 43.2881 40.8666 42.272 40.8666 41.0177C40.8666 39.7637 39.8499 38.7473 38.5962 38.7473Z" fill="black"/>
        <path d="M45.1045 56.8346C44.4772 55.7485 43.089 55.3769 42.0032 56.0037L37.8086 58.4253C36.9641 58.913 36.5181 59.9178 36.7242 60.8714C36.948 61.9048 37.8888 62.6623 38.946 62.6623C39.3311 62.6623 39.7214 62.5644 40.0791 62.3579L44.2736 59.9362C45.3594 59.3089 45.7315 57.9204 45.1045 56.8346Z" fill="black"/>
        <path d="M56.6833 68.4136C55.5972 67.7869 54.2089 68.1585 53.5819 69.2445L51.1603 73.4391C50.3044 74.9211 51.4024 76.8449 53.1243 76.8449C53.909 76.8449 54.672 76.4376 55.0925 75.7095L57.5142 71.515C58.1412 70.4292 57.7694 69.0406 56.6833 68.4136Z" fill="black"/>
        <path d="M93.8405 73.4388L91.4188 69.2443C90.7915 68.1582 89.4027 67.7869 88.3171 68.4133C87.2313 69.0404 86.8592 70.4289 87.4862 71.5147L89.9079 75.7092C90.5751 76.865 92.1443 77.1938 93.2214 76.4016C94.1406 75.7251 94.4105 74.426 93.8405 73.4388Z" fill="black"/>
        <path d="M107.191 58.425L102.997 56.0034C101.911 55.3764 100.523 55.7482 99.8956 56.8343C99.2683 57.9204 99.6404 59.3089 100.727 59.9359L104.921 62.3576C106.08 63.026 107.601 62.5227 108.137 61.3004C108.595 60.2551 108.179 58.9954 107.191 58.425Z" fill="black"/>
        <path d="M111.248 38.7473H106.404C105.15 38.7473 104.134 39.7634 104.134 41.0177C104.134 42.2717 105.15 43.2881 106.404 43.2881H111.248C112.501 43.2881 113.518 42.272 113.518 41.0177C113.518 39.7637 112.502 38.7473 111.248 38.7473Z" fill="black"/>
        <path d="M108.022 20.509C107.395 19.4229 106.006 19.0514 104.921 19.6781L100.726 22.0998C99.8816 22.5874 99.4356 23.5922 99.6417 24.5458C99.8657 25.5792 100.806 26.3368 101.863 26.3368C102.249 26.3368 102.639 26.2388 102.997 26.0323L107.191 23.6106C108.277 22.9833 108.649 21.5948 108.022 20.509Z" fill="black"/>
        <path d="M93.0093 5.49556C91.9232 4.86855 90.5349 5.2404 89.9079 6.32648L87.4862 10.521C86.8592 11.6068 87.2313 12.9953 88.3171 13.6224C89.3899 14.2414 90.8003 13.8625 91.4185 12.7914L93.8402 8.59692C94.4669 7.51083 94.0951 6.12229 93.0093 5.49556Z" fill="black"/>
        <path d="M33.7881 16.0454L19.1068 7.56944C18.0207 6.94271 16.6325 7.31428 16.0055 8.40036C15.3782 9.48616 15.7503 10.8747 16.8364 11.5017L31.5173 19.9777C31.8747 20.1842 32.2653 20.2821 32.6504 20.2821C33.4352 20.2821 34.1981 19.8749 34.6187 19.1468C35.2457 18.0607 34.8739 16.6722 33.7881 16.0454Z" fill="black"/>
        <path d="M24.0662 38.7473H7.11419C5.86045 38.7473 4.84375 39.7634 4.84375 41.0177C4.84375 42.2717 5.86017 43.2881 7.11419 43.2881H24.0662C25.3199 43.2881 26.3366 42.272 26.3366 41.0177C26.3366 39.7637 25.3199 38.7473 24.0662 38.7473Z" fill="black"/>
        <path d="M137.886 38.7473H120.935C119.681 38.7473 118.664 39.7634 118.664 41.0177C118.664 42.2717 119.68 43.2881 120.935 43.2881H137.886C139.14 43.2881 140.157 42.272 140.157 41.0177C140.157 39.7637 139.14 38.7473 137.886 38.7473Z" fill="black"/>
        <path d="M128.995 8.40036C128.368 7.31427 126.98 6.94299 125.894 7.56944L111.213 16.0454C110.127 16.6724 109.755 18.061 110.382 19.1468C110.803 19.8752 111.566 20.2821 112.35 20.2821C112.736 20.2821 113.126 20.1841 113.484 19.9777L128.165 11.5017C129.25 10.8747 129.622 9.48616 128.995 8.40036Z" fill="black"/>
    </svg>
    Permohonan Pelayanan
</h1>
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

<!-- TRACKING WITH MODAL -->
<div class="modal fade" id="modaltracking" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContentt">
            <div style="text-align: center;">
                <!-- <img src="{{ asset('res/loading.gif') }}"> -->
            </div>
        </div>
    </div>
</div>

<div class="row mb-4 mt-4">
    <div class="col-md-4">
    <div class="card shadow">
            <div class="card-header py-3">
                Formulir Permohonan Pelayanan
            </div>
            <div class="card-body">
            <form id="formIndividu" class="mb-2" method="post" action="/pelayananlainnya/InputForm">
            @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{$user[0]->nama_lengkap}}" name="nama_lengkap" id="nama_lengkap" required></textarea>
                </div>
                <div class="form-group">
                    <label>Jenis Pelayanan</label>
                    <select class="form-control" name="pelayanan_lainnya_id" id="exampleFormControlSelect1" required>
                        @foreach($pelayanan as $p)
                        <option value="{{$p->id}}">{{$p->jenis_pelayanan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >Lingkungan</label>
                    <input type="text" value="{{$user[0]->nama_lingkungan}}" class="form-control" id='lingkungan' name='lingkungan' placeholder="Lingkungan" required readonly>
                </div>       
                <div class="form-group">
                    <label >KBG</label>
                    <input type="text" value="{{$user[0]->nama_kbg}}" class="form-control" id='kbg' name='kbg' placeholder="KBG" required readonly>
                </div>  
                <div class="form-group">
                    <label>Tanggal Pelaksanaan Pelayanan</label>
                    <input type="datetime-local" class="form-control" name="jadwal"  id="jadwal" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Alamat Pelaksanaan Pelayanan</label>
                    <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label >Telepon</label>
                    <input type="text" value="{{$user[0]->telepon}}" class="form-control" id='telepon' name='telepon' placeholder="Telepon" required>
                </div>  
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" placeholder="*Boleh Dikosongi" rows="3"></textarea>
                </div>
                <div class="alert alert-info" role="alert">
                   Jika sudah mendaftar, silahkan lihat status pada "Riwayat Pendaftaran Pelayanan"
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Formulir</button> 
            </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                Riwayat Pendaftaran Pelayanan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr style="text-align: center;">
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Pelayanan</th>
                                <th>Lingkungan</th>
                                <th>KBG</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Waktu Pelaksanaan</th>
                                <th>Alamat Pelaksanaan</th>
                                <th>Telepon</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($data as $d)
                            @php $i += 1; @endphp
                            <tr>
                                <td>@php echo $i; @endphp</td>
                                <td st>{{$d->nama_lengkap}}</td>
                                <td st>{{$d->Pelayanan->jenis_pelayanan}}</td>
                                <td st>{{$d->lingkungan}}</td>
                                <td st>{{$d->kbg}}</td>
                                <td st>{{tanggal_indonesia($d->jadwal)}}</td>
                                <td st>{{waktu_indonesia($d->jadwal)}}</td>
                                <td st>{{$d->alamat}}</td>
                                <td st>{{$d->telepon}}</td>
                                <td st>{{$d->keterangan}}</td>
                                <td st>
                                    @if($d->status == "Diproses" || $d->status == "Disetujui KBG" || $d->status == "Disetujui Lingkungan")
                                    
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-info" onclick="detail({{ $d->id }})">Lacak</a>
                                    
                                    @elseif($d->status == "Disetujui Paroki" || $d->status == "Selesai")
                                    
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-success" onclick="detail({{ $d->id }})">Lacak</a>
                                    
                                    @elseif($d->status == "Ditolak")
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-danger" onclick="detail({{ $d->id }})">Lacak</a>

                                    @else
                                    <a href="#modaltracking" data-toggle="modal" class="btn btn-xs btn-danger" onclick="detail({{ $d->id }})">Lacak</a>
                                    @endif
                                </td>
                                <td st>
                                    @if($d->status == "Diproses" || $d->status == "Disetujui KBG" || $d->status == "Disetujui Lingkungan")
                                    <a href="#modal{{$d->id}}" data-toggle="modal" class="btn btn-xs btn-flat btn-danger">Batal</a>
                                    @endif
                                </td>
                            </tr>
                            <!-- EDIT WITH MODAL -->
                            <div class="modal fade" id="modal{{$d->id}}" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" >
                                        <form role="form" method="POST" action="{{ url('pelayananlainnya/Pembatalan') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">Pembatalan Reservasi</h4>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <label>Alasan Pembatalan:</label>
                                                <input type="hidden" name="id" value="{{$d->id}}">
                                                <textarea name="alasan_pembatalan" class="form-control" id="" cols="30" rows="10" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('javascript')
<script>
function detail(id)
{
  $.ajax({
    type:'POST',
    url:'{{ route('pelayananlainnya.detail', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}',
    data:{'_token':'<?php echo csrf_token() ?>',
          'id':id
         },
    success: function(data){
      $('#modalContentt').html(data.msg);
    }
  });
}
</script>
@endsection
@extends('layouts.sbadmin2')

@section('title')
    Riwayat Validasi Formulir Pendaftaran Kursus Persiapan Perkawinan
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 mt-4">
<svg width="35" height="35" viewBox="0 0 348 512" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M338.569 105.162H278.991V66.075C278.991 63.206 277.605 60.514 275.271 58.846L257.544 46.184C263.462 34.227 261.459 19.315 251.515 9.371C245.472 3.328 237.44 0 228.9 0C220.36 0 212.328 3.328 206.285 9.371C193.819 21.837 193.819 42.122 206.285 54.589C212.327 60.632 220.359 63.96 228.9 63.96C234.82 63.96 240.492 62.359 245.43 59.366L261.224 70.647V105.162H86.777V70.647L102.568 59.367C107.502 62.36 113.175 63.96 119.095 63.96C127.637 63.96 135.667 60.632 141.704 54.589C147.747 48.552 151.075 40.522 151.075 31.98C151.075 23.435 147.745 15.405 141.708 9.376C135.67 3.33 127.639 0 119.095 0C110.551 0 102.52 3.33 96.49 9.368C90.445 15.405 87.115 23.436 87.115 31.981C87.115 36.998 88.271 41.835 90.441 46.196L72.73 58.847C70.395 60.515 69.01 63.207 69.01 66.076V105.163H9.43098C4.52498 105.163 0.547974 109.14 0.547974 114.046V163.793C0.547974 168.699 4.52498 172.676 9.43098 172.676H19.421L55.572 504.079C56.064 508.586 59.869 511.999 64.403 511.999H283.587C288.12 511.999 291.927 508.585 292.418 504.079L328.579 172.676H338.569C343.475 172.676 347.452 168.699 347.452 163.793V114.046C347.453 109.14 343.475 105.162 338.569 105.162ZM238.953 42.027C233.41 47.57 224.391 47.57 218.848 42.027C213.308 36.487 213.308 27.474 218.848 21.935C221.62 19.163 225.261 17.778 228.9 17.778C232.539 17.778 236.181 19.164 238.952 21.935C244.492 27.475 244.492 36.488 238.953 42.027ZM109.052 21.93C111.734 19.245 115.3 17.767 119.095 17.767C122.89 17.767 126.456 19.246 129.145 21.939C131.829 24.621 133.308 28.186 133.308 31.981C133.308 35.776 131.829 39.342 129.145 42.024C129.143 42.026 129.14 42.029 129.137 42.032C126.455 44.717 122.889 46.195 119.094 46.195C115.299 46.195 111.733 44.717 109.044 42.025C106.36 39.343 104.881 35.778 104.881 31.982C104.882 28.185 106.36 24.62 109.052 21.93ZM118.923 154.909C114.017 154.909 110.04 158.886 110.04 163.792C110.04 168.698 114.017 172.675 118.923 172.675H310.707L275.62 494.233H72.369L37.292 172.676H88.718C93.624 172.676 97.601 168.699 97.601 163.793C97.601 158.887 93.624 154.91 88.718 154.91H18.314V122.93H329.684V154.91H118.923V154.909Z" fill="black"/>
    <path d="M240.188 253.101H208.646V215.317C208.646 210.411 204.669 206.434 199.763 206.434H148.239C143.333 206.434 139.356 210.411 139.356 215.317V253.101H107.814C102.908 253.101 98.931 257.078 98.931 261.984V313.496C98.931 318.402 102.908 322.379 107.814 322.379H139.356V437.39C139.356 442.296 143.333 446.273 148.239 446.273H199.763C204.669 446.273 208.646 442.296 208.646 437.39V372.398C208.646 367.492 204.669 363.515 199.763 363.515C194.857 363.515 190.88 367.492 190.88 372.398V428.507H157.123V313.497C157.123 308.591 153.146 304.614 148.24 304.614H116.698V270.869H148.24C153.146 270.869 157.123 266.892 157.123 261.986V224.2H190.88V261.984C190.88 266.89 194.857 270.867 199.763 270.867H231.305V304.612H199.763C194.857 304.612 190.88 308.589 190.88 313.495V342.785C190.88 347.691 194.857 351.668 199.763 351.668C204.669 351.668 208.646 347.691 208.646 342.785V322.38H240.188C245.094 322.38 249.071 318.403 249.071 313.497V261.985C249.072 257.078 245.094 253.101 240.188 253.101Z" fill="black"/>
</svg>
    Riwayat Validasi Formulir Pendaftaran Kursus Persiapan Perkawinan
</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Riwayat Validasi Formulir Pendaftaran   
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center; color:black;">
                        <th>KETERANGAN IDENTITAS</th>
                        <th>CALON SUAMI</th>
                        <th>CALON ISTRI</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td style="color:black;">Nama Lengkap</td>
                        <td>{{$d->nama_lengkap_calon_suami}}</td>
                        <td>{{$d->nama_lengkap_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Tempat, Tgl Lahir</td>
                        <td>{{$d->tempat_lahir_calon_suami}}, {{tanggal_indonesia($d->tanggal_lahir_calon_suami)}}</td>
                        <td>{{$d->tempat_lahir_calon_istri}}, {{tanggal_indonesia($d->tanggal_lahir_calon_istri)}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Alamat</td>
                        <td>{{$d->alamat_calon_suami}}</td>
                        <td>{{$d->alamat_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Telepon</td>
                        <td>{{$d->telepon_calon_suami}}</td>
                        <td>{{$d->telepon_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Agama</td>
                        <td>{{$d->agama_calon_suami}}</td>
                        <td>{{$d->agama_calon_istri}}</td>
                    </tr>
                    @if($d->agama_calon_suami == 'Katolik' || $d->agama_calon_istri == 'Katolik')
                    <tr>
                        <td style="color:black;">Paroki</td>
                        <td>{{$d->paroki_calon_suami}}</td>
                        <td>{{$d->paroki_calon_istri}}</td>
                    </tr>
                    @endif
                    <tr style="color:black;">
                        <td><b>IDENTITAS ORANG TUA</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td style="color:black;">Nama Lengkap Ayah</td>
                        <td>{{$d->nama_ayah_calon_suami}}</td>
                        <td>{{$d->nama_ayah_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">Nama Lengkap Ibu</td>
                        <td>{{$d->nama_ibu_calon_suami}}</td>
                        <td>{{$d->nama_ibu_calon_istri}}</td>
                    </tr>
                    <tr style="color:black;">
                        <td><b>LAMPIRAN PRIBADI</b></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td style="color:black;">NIK</td>
                        <td>{{$d->nik_calon_suami}}</td>
                        <td>{{$d->nik_calon_istri}}</td>
                    </tr>
                    <tr>
                        <td style="color:black;">KTP</td>
                        <td><img src="{{asset('file_kpp/ktp/'.$d->ktp_calon_suami)}}" height='80px'/></td>
                        <td><img src="{{asset('file_kpp/ktp/'.$d->ktp_calon_istri)}}" height='80px'/></td>
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_lingkungan_calon_suami) || isset($d->suratpengantar_lingkungan_calon_istri))
                        <td style="color:black;">Surat Pengantar Lingkungan</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_suami))<img src="{{asset('file_kpp/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_lingkungan_calon_istri))<img src="{{asset('file_kpp/suratpengantar_lingkungan/'.$d->suratpengantar_lingkungan_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                    <tr>
                    @if(isset($d->suratpengantar_paroki_calon_suami) || isset($d->suratpengantar_paroki_calon_istri))
                        <td style="color:black;">Surat Pengantar Paroki</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_suami))<img src="{{asset('file_kpp/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_suami)}}" height='80px'/>@endif</td>
                        <td>@if(isset($d->suratpengantar_paroki_calon_istri))<img src="{{asset('file_kpp/suratpengantar_paroki/'.$d->suratpengantar_paroki_calon_istri)}}" height='80px'/>@endif</td>
                    @endif
                    </tr>
                </tbody>
            </table>
            <br><h6 style="color:black;"><b>Tempat & Keterangan KPP:</b> {{$d->lokasi}}, {{$d->keterangan_kursus}}</h6>
            @endforeach
        </div>
    </div>
</div>

<!-- /.container-fluid -->
@endsection

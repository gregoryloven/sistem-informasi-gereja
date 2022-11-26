@extends('layouts.sbuser')

@push('css')
<style>
    #myTable td {text-align: center; vertical-align: middle;}
    .card-img-top {width: 100%; height: 150px; object-fit: cover;}
</style>
@endpush

@section('title')
    Homepage | User
@endsection

@section('content')
<!-- Page Heading -->
<div class="p-3">
    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Layanan Yang Tersedia:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @auth
                @if (Auth::user()->agama == 'Katolik')
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://cdn.antaranews.com/cache/800x533/2020/06/14/Umat-Katolik-Kembali-Ibadah-Di-Gereja-130620-bcs-8.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Umat</h5>
                            <p class="card-text">Pemvalidasian Akun Sebagai Umat Lama dan Pendaftaran Umat Baru</p>
                            <a href="/pendaftaranumat" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://i0.wp.com/rubrikkristen.com/wp-content/uploads/2019/10/images-7.jpeg?fit=678%2C452&ssl=1" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Bayi & Anak</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Bayi & Anak Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptis" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://1.bp.blogspot.com/-dICsh7l5GtE/XNU3rKPRg4I/AAAAAAAABSM/nbBsm-Go42wiI_hTJ14JrnE81p42RohCgCLcBGAs/s1600/baptism.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Dewasa</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Dewasa Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptisdewasa" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.hidupkatolik.com/wp-content/uploads/2017/09/kiman-ilustrasi-kepantasan-menyambut-tuhan-september-2015-hidup-katolik-696x431.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Komuni Pertama</h5>
                            <p class="card-text">Pendaftaran Komuni Pertama & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftarankomuni" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="http://insighttour.id/wp-content/uploads/2020/02/Tata-Cara-Penerimaan-Sakramen-Krisma.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Krisma</h5>
                            <p class="card-text">Pendaftaran Krisma Paroki Setempat & Lintas Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftarankrisma" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://sanyospwt.files.wordpress.com/2019/09/1.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Kursus Persiapan Perkawinan</h5>
                            <p class="card-text">Pendaftaran Kursus Persiapan Perkawinan</p>
                            <a href="/pendaftarankpp" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.katolisitas.org/wp-content/uploads/2008/08/sakramen-perkawinan.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Perkawinan</h5>
                            <p class="card-text">Pendaftaran Perkawinan & Pemberkatan Pernikahan</p><br>
                            <a href="/pendaftaranperkawinan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1640405169/fsgrr5bve4hpxkjpvdv0.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Permohonan Pelayanan</h5>
                            <p class="card-text">Pendaftaran Pelayanan Lainnya & Riwayat Pendaftaran</p><br>
                            <a href="/pelayananlainnya" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="http://assets.kompasiana.com/items/album/2021/08/10/eouwr4lu4aa1i4o-611294b006310e51dc5ff517.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pengurapan Orang Sakit</h5>
                            <p class="card-text">Pendaftaran Pengurapan Orang Sakit & Perminyakan</p><br>
                            <a href="/pendaftaranpengurapan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.katolisitas.org/wp-content/uploads/2013/03/misdinar-e1465811062714.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Petugas</h5>
                            <p class="card-text">Pendaftaran Petugas Liturgi & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftaranpetugas" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>
                @endif

                @else
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://cdn.antaranews.com/cache/800x533/2020/06/14/Umat-Katolik-Kembali-Ibadah-Di-Gereja-130620-bcs-8.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Umat</h5>
                            <p class="card-text">Pemvalidasian Akun Sebagai Umat Lama dan Pendaftaran Umat Baru</p>
                            <a href="/pendaftaranumat" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://i0.wp.com/rubrikkristen.com/wp-content/uploads/2019/10/images-7.jpeg?fit=678%2C452&ssl=1" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Bayi & Anak</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Bayi & Anak Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptis" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://1.bp.blogspot.com/-dICsh7l5GtE/XNU3rKPRg4I/AAAAAAAABSM/nbBsm-Go42wiI_hTJ14JrnE81p42RohCgCLcBGAs/s1600/baptism.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Dewasa</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Dewasa Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptisdewasa" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.hidupkatolik.com/wp-content/uploads/2017/09/kiman-ilustrasi-kepantasan-menyambut-tuhan-september-2015-hidup-katolik-696x431.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Komuni Pertama</h5>
                            <p class="card-text">Pendaftaran Komuni Pertama & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftarankomuni" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="http://insighttour.id/wp-content/uploads/2020/02/Tata-Cara-Penerimaan-Sakramen-Krisma.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Krisma</h5>
                            <p class="card-text">Pendaftaran Krisma Paroki Setempat & Lintas Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftarankrisma" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://sanyospwt.files.wordpress.com/2019/09/1.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Kursus Persiapan Perkawinan</h5>
                            <p class="card-text">Pendaftaran Kursus Persiapan Perkawinan</p>
                            <a href="/pendaftarankpp" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.katolisitas.org/wp-content/uploads/2008/08/sakramen-perkawinan.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Perkawinan</h5>
                            <p class="card-text">Pendaftaran Perkawinan & Pemberkatan Pernikahan</p><br>
                            <a href="/pendaftaranperkawinan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1640405169/fsgrr5bve4hpxkjpvdv0.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Permohonan Pelayanan</h5>
                            <p class="card-text">Pendaftaran Pelayanan Lainnya & Riwayat Pendaftaran</p><br>
                            <a href="/pelayananlainnya" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="http://assets.kompasiana.com/items/album/2021/08/10/eouwr4lu4aa1i4o-611294b006310e51dc5ff517.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pengurapan Orang Sakit</h5>
                            <p class="card-text">Pendaftaran Pengurapan Orang Sakit & Perminyakan</p><br>
                            <a href="/pendaftaranpengurapan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.katolisitas.org/wp-content/uploads/2013/03/misdinar-e1465811062714.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Petugas</h5>
                            <p class="card-text">Pendaftaran Petugas Liturgi & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftaranpetugas" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>
                @endauth
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://mmc.tirto.id/image/2021/12/25/misa-natal-gereja-katedral-jakarta-antarafoto-1_ratio-16x9.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Reservasi Misa</h5>
                            <p class="card-text">Pemesanan Tiket Misa & Riwayat Pemesanan</p><br>
                            <a href="/reservasimisa" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://paroki-sragen.or.id/wp-content/uploads/2019/03/sakramen-tobat.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Reservasi Pengakuan Dosa</h5>
                            <p class="card-text">Pemesanan Tiket Pengakuan Dosan & Riwayat Pemesanan</p>
                            <a href="/reservasitobat" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
</script>
@endsection
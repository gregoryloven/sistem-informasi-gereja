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
            
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/pendaftaran_umat.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Umat</h5>
                            <p class="card-text">Pemvalidasian Akun Sebagai Umat Lama dan Pendaftaran Umat Baru</p>
                            <a href="/pendaftaranumat" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/baptis_bayi.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Bayi & Anak</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Bayi & Anak Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptis" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/baptis_dewasa.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Dewasa</h5>
                            <p class="card-text">Pendaftaran Sakramen Baptis Dewasa Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftaranbaptisdewasa" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/komuni.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Komuni Pertama</h5>
                            <p class="card-text">Pendaftaran Komuni Pertama & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftarankomuni" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/krisma.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Krisma</h5>
                            <p class="card-text">Pendaftaran Krisma Paroki Setempat & Lintas Serta Riwayat Pendaftaran</p>
                            <a href="/pendaftarankrisma" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/kpp.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Kursus Persiapan Perkawinan</h5>
                            <p class="card-text">Pendaftaran Kursus Persiapan Perkawinan</p>
                            <a href="/pendaftarankpp" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/perkawinan.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Perkawinan</h5>
                            <p class="card-text">Pendaftaran Perkawinan & Pemberkatan Pernikahan</p><br>
                            <a href="/pendaftaranperkawinan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/pelayanan.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Permohonan Pelayanan</h5>
                            <p class="card-text">Pendaftaran Pelayanan Lainnya & Riwayat Pendaftaran</p><br>
                            <a href="/pelayananlainnya" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/pengurapan.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pengurapan Orang Sakit</h5>
                            <p class="card-text">Pendaftaran Pengurapan Orang Sakit & Perminyakan</p><br>
                            <a href="/pendaftaranpengurapan" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/petugas.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Petugas</h5>
                            <p class="card-text">Pendaftaran Petugas Liturgi & Riwayat Pendaftaran</p><br>
                            <a href="/pendaftaranpetugas" class="btn btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>

                

                <!-- <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/misa.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Reservasi Misa</h5>
                            <p class="card-text">Pemesanan Tiket Misa & Riwayat Pemesanan</p><br>
                            <a href="/reservasimisa" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/landing_page/tobat.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Reservasi Pengakuan Dosa</h5>
                            <p class="card-text">Pemesanan Tiket Pengakuan Dosan & Riwayat Pemesanan</p>
                            <a href="/reservasitobat" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
</script>
@endsection
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
    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Fitur yang terdapat Pada Webiste:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @can('agama-permission')
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://cdn.antaranews.com/cache/800x533/2020/06/14/Umat-Katolik-Kembali-Ibadah-Di-Gereja-130620-bcs-8.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Umat</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranumat" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://t-2.tstatic.net/medan/foto/bank/images/PEMBAPTISAN-KRISTEN.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Bayi</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranbaptis" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://t-2.tstatic.net/medan/foto/bank/images/PEMBAPTISAN-KRISTEN.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis Dewasa</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranbaptisdewasa" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.hidupkatolik.com/wp-content/uploads/2017/09/kiman-ilustrasi-kepantasan-menyambut-tuhan-september-2015-hidup-katolik-696x431.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Komuni Pertama</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftarankomuni" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="http://insighttour.id/wp-content/uploads/2020/02/Tata-Cara-Penerimaan-Sakramen-Krisma.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Krisma</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftarankrisma" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1640405169/fsgrr5bve4hpxkjpvdv0.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Permohonan Pelayanan</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pelayananlainnya" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.katolisitas.org/wp-content/uploads/2013/03/misdinar-e1465811062714.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Petugas</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranpetugas" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://mmc.tirto.id/image/2021/12/25/misa-natal-gereja-katedral-jakarta-antarafoto-1_ratio-16x9.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Tiket Reservasi</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/reservasimisa" class="btn btn-primary">Gunakan Fitur</a>
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
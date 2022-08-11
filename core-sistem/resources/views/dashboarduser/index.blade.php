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
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://mmc.tirto.id/image/2021/12/25/misa-natal-gereja-katedral-jakarta-antarafoto-1_ratio-16x9.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Permohonan Pelayanan</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pelayananlainnya" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://i2.wp.com/kap.or.id/wp-content/uploads/2018/03/IMG_1768.jpg?ssl=1" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Petugas</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranpetugas" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://cdn.antaranews.com/cache/800x533/2020/06/14/Umat-Katolik-Kembali-Ibadah-Di-Gereja-130620-bcs-8.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Pendaftaran Akun</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranakun" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://t-2.tstatic.net/medan/foto/bank/images/PEMBAPTISAN-KRISTEN.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Baptis</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="/pendaftaranbaptis" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card" style="width: 18rem;">
                        <img src="https://www.gerejasmi.or.id/images/gereja-smi/gallery/IMG_0095.JPG" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Tiket Reservasi</h5>
                            <p class="card-text">Lorem Ipsum is simply dummy text of the printing and industry. Lorem Ipsum has been the.</p>
                            <a href="#" class="btn btn-primary">Gunakan Fitur</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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


@endsection

@section('javascript')
<script>
</script>
@endsection
@extends('layouts.onepage')

@section('content')
    @if ($cekTenant == null)
        @if($role == 'superadmin')
            <!--========================= service-section start========================= -->
            <section id="features" class="service-section gray-bg pt-150 pb-70">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">
                            <div class="section-title text-center mb-55">
                                <span class="wow fadeInDown" data-wow-delay=".2s"></span>
                                <h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Admin Tidak Bisa Melakukan Pendaftaran</h2>
                                {{-- Anda Dapat Login Menggunakan Akun Anda Saat ini --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <!--========================= service-section end========================= -->
        @else
            <!--========================= service-section start========================= -->
            <section id="features" class="service-section gray-bg pt-150 pb-70">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">
                            <div class="section-title text-center mb-55">
                                <span class="wow fadeInDown" data-wow-delay=".2s"></span>
                                <h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Pendaftaran Gereja</h2>
                                {{-- <p class="wow fadeInUp" data-wow-delay=".6s">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore.</p> --}}
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Informasi!</h5>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <form id="sectionForm" role="form" method="POST" action="{{ url('simpandaftargereja') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">  
                                <div class="col-md-6">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="user_name"class="mb-10"><b>Nama Paroki</b></label>
                                            <input type="text" class="form-control" id="nama_paroki" name="nama_paroki" required data-error="Tolong isi nomor nama usaha anda" required>
                                        </div>                                 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-body">  
                                        <div class="form-group">
                                            <label for="user_telepon"class="mb-10"><b>Nomor Telepon</b></label>
                                            <input type="number" class="form-control" min="0" id="nomor_telepon" name="nomor_telepon" data-error="Tolong isi nomor telepon usaha anda" required>
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-md-12 mt-30">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="user_alamat" class="mb-10"><b>Alamat</b></label>
                                            <textarea class="form-control " name="alamat" id="alamat" cols="20" rows="3" data-error="Tolong isi nomor telepon usaha anda" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-30">
                                    <label for="user_name"class="mb-10"><b>Domain Website</b></label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="domain" name="domain" data-error="Tolong isi nama domain yang diinginkan" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">.localhost</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-30">
                                    <div class="submit-button text-center">
                                        <button class="btn btn-primary btn-lg btn-flat" id="submit" type="submit"><i class="fa-solid fa-save"></i> Daftar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <hr>
            <!--========================= service-section end========================= -->
        @endif
    @else
    <!--========================= service-section start========================= -->
    <section id="features" class="service-section gray-bg pt-150 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">
                    <div class="section-title text-center mb-55">
                        <span class="wow fadeInDown" data-wow-delay=".2s"></span>
                        <h2 class="mb-15 wow fadeInUp" data-wow-delay=".4s">Anda Telah Mendaftar Untuk Pembuatan Sistem</h2>
                        Anda Dapat Login Menggunakan Akun Anda Saat ini
                        <div class="text-center m-3 ow fadeInUp"><a class="btn btn-primary btn btn-flat btn-sm" href="http://{{$cekTenant->domain}}:8000/">Kunjung Website Anda</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!--========================= service-section end========================= -->
    @endif
@endsection
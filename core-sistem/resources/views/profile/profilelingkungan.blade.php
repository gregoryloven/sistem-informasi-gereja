@extends('layouts.sbkl')

@push('css')
<style>
    body {
    margin: 0;
    /* padding-top: 40px; */
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
}
.account-settings .user-profile {
    margin: 0 0 1rem 0;
    padding-bottom: 1rem;
    text-align: center;
}
.account-settings .user-profile .user-avatar {
    margin: 0 0 1rem 0;
}
.account-settings .user-profile .user-avatar img {
    width: 90px;
    height: 90px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    border-radius: 100px;
}
.account-settings .user-profile h5.user-name {
    margin: 0 0 0.5rem 0;
}
.account-settings .user-profile h6.user-email {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 400;
    color: #9fa8b9;
}
.account-settings .about {
    margin: 2rem 0 0 0;
    text-align: center;
}
.account-settings .about h5 {
    margin: 0 0 15px 0;
    color: #007ae1;
}
.account-settings .about p {
    font-size: 0.825rem;
}
.form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .950rem;
    background: #ffffff;
    color: #2e323c;
}

.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}

</style>
@endpush

@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Informasi!</h5>
    {{ session('status') }}
</div>
@elseif(session('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Informasi!</h5>
    {{ session('error') }}
</div>
@endif
<form class="mb-2" method="post" action="{{ url('profilelingkungan/update/'.$data->id )}}">
@csrf
	<div class="card h-100">
		<div class="card-body">
		<h1 class="h3 mb-2 text-gray-800">Profile</h1><br>
			<div class="row gutters">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<h6 class="mb-2 text-primary">Detail Akun</h6>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
						<label for="namaLengkap">Nama Lengkap</label>
						<input type="text" class="form-control" value="{{$data->nama_lengkap}}" id="namaLengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
						<label for="telepon">Telepon</label>
						<input type="text" class="form-control" value="{{$data->telepon}}" id="telepon" name="telepon" placeholder="Telepon" required>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="form-group">
						<label for="lingkungan">Lingkungan</label>
						<input type="text" class="form-control" value="{{$data->lingkungan->nama_lingkungan}}" id="lingkungan" placeholder="Lingkungan" readonly>
					</div>
				</div>
			</div>
			<div class="row gutters">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="text-right">
						<button type="button" class="btn btn-secondary">Cancel</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection
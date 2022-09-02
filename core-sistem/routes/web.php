<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParokiController;
use App\Http\Controllers\LingkunganController;
use App\Http\Controllers\KbgController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\BaptisController;
use App\Http\Controllers\KomuniPertamaController;
use App\Http\Controllers\KrismaController;
use App\Http\Controllers\MisaController;
use App\Http\Controllers\TobatController;
use App\Http\Controllers\PengurapanOrangSakitController;
use App\Http\Controllers\PelayananLainnyaController;
use App\Http\Controllers\PendaftaranPetugasController;
use App\Http\Controllers\PendaftaranBaptisController;
use App\Http\Controllers\PendaftaranKomuniController;
use App\Http\Controllers\PemindahanKbgController;
use App\Http\Controllers\ValidasiAdminController;
use App\Http\Controllers\ValidasiKbgController;
use App\Http\Controllers\ValidasiKLController;
use App\Http\Controllers\ListEventController;
use App\Http\Controllers\DashboardUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain('localhost')->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::domain('{tenant}.localhost')->middleware('tenant')->group(function(){
    Route::get('/', function ($tenant) {
        return view('welcome');
    });

    Route::get('/sbadmin2', function () {
        return view('layouts.sbadmin2');
    });

    Route::get('/sbofficer2', function () {
        return view('layouts.sbofficer2');
    });

    Route::get('/sbkbg', function () {
        return view('layouts.sbkbg');
    });

    Route::get('/sbkl', function () {
        return view('layouts.sbkl');
    });

    Route::get('/sbuser', function () {
        return view('layouts.sbuser');
    });

    Route::get('/profile', function () {
        return view('profile.index');
    });

    //User KL
    // Route::resource('userkl', UserKLController::class);

    //User Kbg
    // Route::resource('usersKbg', UserKbgController::class);

    //Dashboard User
    
    Route::get('/dashboarduser', function () {
        return view('dashboarduser.index');
    });

    //List Event Admin
    Route::resource('listevents', ListEventController::class);
    Route::post('/listevents/EditForm', [ListEventController::class, 'EditForm'])->name('listevents.EditForm');

    //Paroki
    Route::resource('parokis', ParokiController::class);
    Route::post('/parokis/EditForm', [ParokiController::class, 'EditForm'])->name('parokis.EditForm');

    //Lingkungan
    Route::resource('lingkungans', LingkunganController::class);
    Route::post('/lingkungans/EditForm', [LingkunganController::class, 'EditForm'])->name('lingkungans.EditForm');

    //KBG
    Route::resource('kbgs', KbgController::class);
    Route::post('/kbgs/EditForm', [KbgController::class, 'EditForm'])->name('kbgs.EditForm');

    //User
    Route::resource('users', UserController::class);

    //Tambah Akun Ketua Lingkungan
    Route::get('userKL', [UserController::class, 'DaftarKL'])->name('user.kl');
    Route::post('/user/TambahKL', [UserController::class, 'TambahKL'])->name('user.TambahKL');
    Route::post('/user/TambahAllKL', [UserController::class, 'TambahAllKL'])->name('user.TambahAllKL');

    //Tambah Akun Ketua KBG
    Route::get('userKKBG', [UserController::class, 'DaftarKKBG'])->name('user.kkbg');
    Route::post('/user/TambahKKBG', [UserController::class, 'TambahKKBG'])->name('user.TambahKKBG');

    //Keluarga
    Route::resource('keluargas', KeluargaController::class);

    //Baptis
    Route::resource('baptiss', BaptisController::class);
    Route::post('/baptiss/EditForm', [BaptisController::class, 'EditForm'])->name('baptiss.EditForm');


    //Komuni Pertama
    Route::resource('komunipertamas', KomuniPertamaController::class);
    Route::post('/komunipertamas/EditForm', [BaptisController::class, 'EditForm'])->name('komunipertamas.EditForm');

    //Krisma
    Route::resource('krismas', KrismaController::class);
    Route::post('/krismas/EditForm', [BaptisController::class, 'EditForm'])->name('krismas.EditForm');

    //Misa
    Route::resource('misas', MisaController::class);
    Route::get('reservasi', [MisaController::class, 'reservasi'])->name('misas.reservasi');
    Route::post('/misas/BookMisa', [MisaController::class, 'BookMisa'])->name('misas.BookMisa');
    Route::post('/misas/EditForm', [MisaController::class, 'EditForm'])->name('misas.EditForm');
    Route::get('/misas/DetailMisa/{id}', [MisaController::class, 'show'])->name('misas.DetailMisa');

    //Tobat
    Route::resource('tobats', TobatController::class);
    Route::post('/tobats/EditForm', [TobatController::class, 'EditForm'])->name('tobats.EditForm');
    Route::get('/tobats/DetailTobat/{id}', [TobatController::class, 'show'])->name('tobats.DetailTobat');

    //Pengurapan Orang Sakit
    Route::resource('pengurapansakits', PengurapanOrangSakitController::class);
    Route::post('/pengurapansakits/EditForm', [PengurapanOrangSakitController::class, 'EditForm'])->name('pengurapansakits.EditForm');
    Route::get('/pengurapansakits/DetailPengurapan/{id}', [PengurapanOrangSakitController::class, 'show'])->name('pengurapansakits.DetailTobat');

    //Permohonan Pelayanan
    Route::resource('pelayananlainnya', PelayananLainnyaController::class);
    Route::post('/pelayananlainnya/InputForm', [PelayananLainnyaController::class, 'InputForm'])->name('pelayananlainnya.InputForm');
    Route::post('/pelayananlainnya/InputFormAll', [PelayananLainnyaController::class, 'InputFormAll'])->name('pelayananlainnya.InputFormAll');
    Route::post('/pelayananlainnya/Pembatalan', [PelayananLainnyaController::class, 'Pembatalan'])->name('pelayananlainnya.Pembatalan');
    Route::post('/pelayananlainnya/detail', [PelayananLainnyaController::class, 'detail'])->name('pelayananlainnya.detail');


    //Pendaftaran Petugas Liturgi
    Route::resource('pendaftaranpetugas', PendaftaranPetugasController::class);
    Route::get('/pendaftaranpetugas/OpenForm/{id}', [PendaftaranPetugasController::class, 'OpenForm'])->name('pendaftaranpetugas.OpenForm');
    Route::post('/pendaftaranpetugas/InputForm', [PendaftaranPetugasController::class, 'InputForm'])->name('pendaftaranpetugas.InputForm');
    Route::post('/pendaftaranpetugas/Pembatalan', [PendaftaranPetugasController::class, 'Pembatalan'])->name('pendaftaranpetugas.Pembatalan');
    Route::post('/pendaftaranpetugas/detail', [PendaftaranPetugasController::class, 'detail'])->name('pendaftaranpetugas.detail');

    //Pendaftaran Baptis
    Route::resource('pendaftaranbaptis', PendaftaranBaptisController::class);
    Route::post('/pendaftaranbaptis/InputForm', [PendaftaranBaptisController::class, 'InputForm'])->name('pendaftaranbaptis.InputForm');
    Route::get('/pendaftaranbaptis/OpenForm/{id}', [PendaftaranBaptisController::class, 'OpenForm'])->name('pendaftaranbaptis.OpenForm');
    Route::post('/pendaftaranbaptis/Pembatalan', [PendaftaranBaptisController::class, 'Pembatalan'])->name('pendaftaranbaptis.Pembatalan');
    Route::post('/pendaftaranbaptis/detail', [PendaftaranBaptisController::class, 'detail'])->name('pendaftaranbaptis.detail');

    //Pendaftaran Komuni
    Route::resource('pendaftarankomuni', PendaftaranKomuniController::class);
    Route::post('/pendaftarankomuni/InputForm', [PendaftaranKomuniController::class, 'InputForm'])->name('pendaftarankomuni.InputForm');
    Route::get('/pendaftarankomuni/OpenForm/{id}', [PendaftaranKomuniController::class, 'OpenForm'])->name('pendaftarankomuni.OpenForm');
    Route::post('/pendaftarankomuni/detail', [PendaftaranKomuniController::class, 'detail'])->name('pendaftarankomuni.detail');

    //Validasi Admin
    Route::get('validasiAdminPelayanan', [ValidasiAdminController::class, 'pelayanan'])->name('validasiAdmin.pelayanan');
    Route::post('/validasiAdmin/acceptpelayanan', [ValidasiAdminController::class, 'AcceptPelayanan'])->name('validasiAdmin.AcceptPelayanan');
    Route::post('/validasiAdmin/declinepelayanan', [ValidasiAdminController::class, 'DeclinePelayanan'])->name('validasiAdmin.DeclinePelayanan');
    Route::post('/validasiAdmin/pembatalanpelayanan', [ValidasiAdminController::class, 'PembatalanPelayanan'])->name('validasiAdmin.PembatalanPelayanan');

    Route::get('validasiAdminPetugas', [ValidasiAdminController::class, 'petugas'])->name('validasiAdmin.petugas');
    Route::post('/validasiAdmin/acceptpetugas', [ValidasiAdminController::class, 'AcceptPetugas'])->name('validasiAdmin.AcceptPetugas');
    Route::post('/validasiAdmin/declinepetugas', [ValidasiAdminController::class, 'DeclinePetugas'])->name('validasiAdmin.DeclinePetugas');

    Route::get('validasiAdminBaptis', [ValidasiAdminController::class, 'baptis'])->name('validasiAdmin.baptis');
    Route::post('/validasiAdmin/acceptbaptis', [ValidasiAdminController::class, 'AcceptBaptis'])->name('validasiAdmin.AcceptBaptis');
    Route::post('/validasiAdmin/declinebaptis', [ValidasiAdminController::class, 'DeclineBaptis'])->name('validasiAdmin.DeclineBaptis');
    Route::post('/validasiAdmin/pembatalanbaptis', [ValidasiAdminController::class, 'PembatalanBaptis'])->name('validasiAdmin.PembatalanBaptis');

    Route::get('validasiAdminKomuni', [ValidasiAdminController::class, 'komuni'])->name('validasiAdmin.komuni');
    Route::post('/validasiAdmin/acceptkomuni', [ValidasiAdminController::class, 'AcceptKomuni'])->name('validasiAdmin.AcceptKomuni');
    Route::post('/validasiAdmin/declinekomuni', [ValidasiAdminController::class, 'DeclineKomuni'])->name('validasiAdmin.DeclineKomuni');
    Route::post('/validasiAdmin/pembatalankomuni', [ValidasiAdminController::class, 'PembatalanKomuni'])->name('validasiAdmin.PembatalanKomuni');


    // validasi Kbg
    Route::get('validasiKbgPelayanan', [ValidasiKbgController::class, 'pelayanan'])->name('validasiKbg.pelayanan');
    Route::post('/validasiKbg/acceptpelayanan', [ValidasiKbgController::class, 'AcceptPelayanan'])->name('validasiKbg.AcceptPelayanan');
    Route::post('/validasiKbg/declinepelayanan', [ValidasiKbgController::class, 'DeclinePelayanan'])->name('validasiAdmin.DeclinePelayanan');

    Route::get('validasiKbgBaptis', [ValidasiKbgController::class, 'baptis'])->name('validasiKbg.baptis');
    Route::post('/validasiKbg/acceptbaptis', [ValidasiKbgController::class, 'AcceptBaptis'])->name('validasiKbg.AcceptBaptis');
    Route::post('/validasiKbg/declinebaptis', [ValidasiKbgController::class, 'DeclineBaptis'])->name('validasiKbg.DeclineBaptis');

    Route::get('validasiKbgKomuni', [ValidasiKbgController::class, 'komuni'])->name('validasiKbg.komuni');
    Route::post('/validasiKbg/acceptkomuni', [ValidasiKbgController::class, 'AcceptKomuni'])->name('validasiKbg.AcceptKomuni');
    Route::post('/validasiKbg/declinekomuni', [ValidasiKbgController::class, 'DeclineKomuni'])->name('validasiKbg.DeclineKomuni');


    // validasi KL
    Route::get('validasiKLPelayanan', [ValidasiKLController::class, 'pelayanan'])->name('validasiKL.pelayanan');
    Route::post('/validasiKL/acceptpelayanan', [ValidasiKLController::class, 'AcceptPelayanan'])->name('validasiKL.AcceptPelayanan');
    Route::post('/validasiKL/declinepelayanan', [ValidasiKLController::class, 'DeclinePelayanan'])->name('validasiKL.DeclinePelayanan');

    Route::get('validasiKLBaptis', [ValidasiKLController::class, 'baptis'])->name('validasiKL.baptis');
    Route::post('/validasiKL/acceptbaptis', [ValidasiKLController::class, 'AcceptBaptis'])->name('validasiKL.AcceptBaptis');
    Route::post('/validasiKL/declinebaptis', [ValidasiKLController::class, 'DeclineBaptis'])->name('validasiKL.DeclineBaptis');
    
    Route::get('validasiKLKomuni', [ValidasiKLController::class, 'komuni'])->name('validasiKL.komuni');
    Route::post('/validasiKL/acceptkomuni', [ValidasiKLController::class, 'AcceptKomuni'])->name('validasiKL.AcceptKomuni');
    Route::post('/validasiKL/declinekomuni', [ValidasiKLController::class, 'DeclineKomuni'])->name('validasiKL.DeclineKomuni');


    //Pemindahan Kbg
    Route::resource('pemindahankbg', PemindahanKbgController::class);
    Route::post('/pemindahanKBG/UpdateForm', [PemindahanKbgController::class, 'UpdateForm'])->name('pemindahanKBG.UpdateForm');

    //Complete Register
    Route::get('/complete-register', function () {
        return view('auth.complete-register');
    });

    Route::get('/auth/redirect', [UserController::class, 'redirect'])->name('auth.redirect');
    Route::post('/auth/complete-register', [UserController::class, 'complete_register'])->name('auth.complete-register');

});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
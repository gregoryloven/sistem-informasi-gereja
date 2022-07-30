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
use App\Http\Controllers\PemindahanKbgController;
use App\Http\Controllers\ValidateController;
use App\Http\Controllers\ValidasiKbgController;
use App\Http\Controllers\ValidasiKLController;

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

    //User KL
    Route::resource('userkl', UserKLController::class);

    //User Kbg
    Route::resource('usersKbg', UserKbgController::class);

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
    Route::post('/pelayananlainnya/UpdateForm', [PelayananLainnyaController::class, 'UpdateForm'])->name('pelayananlainnya.UpdateForm');

    //Pendaftaran Petugas Liturgi
    Route::resource('pendaftaranpetugas', PendaftaranPetugasController::class);
    Route::post('/pendaftaranpetugas/InputForm', [PendaftaranPetugasController::class, 'InputForm'])->name('pendaftaranpetugas.InputForm');

    //Pendaftaran Baptis
    Route::resource('pendaftaranbaptis', PendaftaranBaptisController::class);
    Route::post('/pendaftaranbaptis/InputForm', [PendaftaranBaptisController::class, 'InputForm'])->name('pendaftaranbaptis.InputForm');
    
    //Validasi Admin
    Route::resource('validate', ValidateController::class);
    Route::post('/validateMisa/accept', [ValidateController::class, 'Accept'])->name('validate.Accept');
    Route::post('/validateMisa/decline', [ValidateController::class, 'Decline'])->name('validate.Decline');
    Route::post('/validatePetugas/accept', [ValidateController::class, 'AcceptPetugas'])->name('validate.AcceptPetugas');
    Route::post('/validatePetugas/decline', [ValidateController::class, 'DeclinePetugas'])->name('validate.DeclinePetugas');

    // Validate Kbg
    Route::resource('validasiKbg', ValidasiKbgController::class);
    Route::post('/validateMisaKbg/accept', [ValidasiKbgController::class, 'Accept'])->name('validate.Accept');
    Route::post('/validateMisaKbg/decline', [ValidasiKbgController::class, 'Decline'])->name('validate.Decline');

    // Validate KL
    Route::resource('validasiKL', ValidasiKLController::class);
    Route::post('/validateMisaKL/accept', [ValidasiKLController::class, 'Accept'])->name('validate.Accept');
    Route::post('/validateMisaKL/decline', [ValidasiKLController::class, 'Decline'])->name('validate.Decline');

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

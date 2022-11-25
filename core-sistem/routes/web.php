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
use App\Http\Controllers\PerkawinanController;
use App\Http\Controllers\MisaController;
use App\Http\Controllers\TobatController;
use App\Http\Controllers\PengurapanOrangSakitController;
use App\Http\Controllers\PelayananLainnyaController;
use App\Http\Controllers\PendaftaranUmatController;
use App\Http\Controllers\PendaftaranPetugasController;
use App\Http\Controllers\PendaftaranBaptisController;
use App\Http\Controllers\PendaftaranKomuniController;
use App\Http\Controllers\PendaftaranKrismaController;
use App\Http\Controllers\ReservasiMisaController;
use App\Http\Controllers\ReservasiTobatController;
use App\Http\Controllers\PemindahanKbgController;
use App\Http\Controllers\ValidasiAdminController;
use App\Http\Controllers\ValidasiKbgController;
use App\Http\Controllers\ValidasiKLController;
use App\Http\Controllers\ListEventController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\UmatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendaftaranPerkawinanController;
use App\Http\Controllers\PendaftaranKppController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\KppController;
use App\Http\Controllers\BaptisDewasaController;

use App\Http\Controllers\LandlordController;

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
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    //TEMPLATE LAYOUTS 
    Route::get('/onepage', function () {
        return view('layouts.onepage');
    });

    Route::get('/sbsuperadmin2', function () {
        return view('layouts.sbsuperadmin2');
    });

    //SEMUA CONTROLLER 
    Route::get('/', [LandlordController::class, 'index']);
    Route::middleware(['auth'])->group(function(){
        Route::get('/daftargereja', [LandlordController::class, 'daftargereja']);
        Route::post('/simpandaftargereja', [LandlordController::class, 'simpandaftargereja']);
        Route::get('/dashboards', [LandlordController::class, 'dashboards']);
        Route::get('/dashboards/tenant', [LandlordController::class, 'tenant']);
        Route::get('/dashboards/user', [LandlordController::class, 'user']);
        Route::delete('/dashboards/deletetenant', [LandlordController::class, 'deletetenant'])->name('dashboards.deletetenant');
        Route::delete('/dashboards/deleteuser', [LandlordController::class, 'deleteuser'])->name('dashboards.deleteuser');
    });
    // Route::get('/auth/redirect-landlord', [LandlordController::class, 'redirect_landlord'])->name('auth.redirect.landlord');
    // Route::post('/auth/complete-register-landlord', [LandlordController::class, 'complete_register_landlord'])->name('auth.complete-register.landlord');
});

Route::domain('{tenant}.localhost')->middleware('tenant')->group(function(){
    // Route::get('/', function ($tenant) {
    //     return view('welcome');
    // });
    Route::get('/', [DashboardUserController::class, 'index']);
    Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('dashboardadmin.index');
    Route::get('/dashboard/adminkbg', [DashboardAdminController::class, 'indexkbg'])->name('dashboardadmin.indexkbg');
    Route::get('/dashboard/adminlingkungan', [DashboardAdminController::class, 'indexlingkungan'])->name('dashboardadmin.indexlingkungan');;

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
    Route::get('profileumat', [ProfileController::class, 'data'])->name('profile.umat');
    Route::get('profilekbg', [ProfileController::class, 'data'])->name('profile.kbg');
    Route::get('profilelingkungan', [ProfileController::class, 'data'])->name('profile.lingkungan');
    Route::get('profileadmin', [ProfileController::class, 'data'])->name('profile.admin');
    Route::post('/profileumat/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profilelingkungan/update/{id}', [ProfileController::class, 'update'])->name('profile.updatelingkungan');
    Route::post('/profilekbg/update/{id}', [ProfileController::class, 'update'])->name('profile.updatekbg');
    Route::post('/profileadmin/update/{id}', [ProfileController::class, 'update'])->name('profile.updateadmin');

    Route::resource('ubahpassword', PasswordController::class);

    //User KL
    // Route::resource('userkl', UserKLController::class);

    //User Kbg
    // Route::resource('usersKbg', UserKbgController::class);

    //Dashboard User
    
    Route::get('/dashboarduser', function () {
        return view('dashboarduser.index');
    });

    //List Event Admin
    Route::resource('listevent', ListEventController::class);
    Route::post('/listevent/EditForm', [ListEventController::class, 'EditForm'])->name('listevent.EditForm');
    Route::post('/listevent/selesai', [ListEventController::class, 'selesai'])->name('listevent.selesai');

    //Daftar Umat 
    Route::get('umat', [UmatController::class, 'umatAll'])->name('umat.umatAll');
    Route::get('umatKbg', [UmatController::class, 'umatKbg'])->name('umat.umatKbg');
    Route::post('/fetchkbg', [UmatController::class, 'fetchkbg'])->name('fetchkbg');
    Route::post('/umat/TambahUmatKBG', [UmatController::class, 'TambahUmatKBG'])->name('umat.TambahUmatKBG');
    Route::post('/umat/EditFormUmatKBG', [UmatController::class, 'EditFormUmatKBG'])->name('umat.EditFormUmatKBG');
    Route::post('/umat/UbahUmatKBG/{id}', [UmatController::class, 'UbahUmatKBG'])->name('umat.UbahUmatKBG');

    //Daftar Umat Lingkungan
    Route::get('umatLingkungan', [UmatController::class, 'umatLingkungan'])->name('umat.umatLingkungan');
    Route::post('/fetchkbgumat', [UmatController::class, 'fetchkbgumat'])->name('fetchkbgumat');
    Route::post('/umat/EditFormUmatLingkungan', [UmatController::class, 'EditFormUmatLingkungan'])->name('umat.EditFormUmatLingkungan');
    Route::post('/umat/UbahUmatLingkungan/{id}', [UmatController::class, 'UbahUmatLingkungan'])->name('umat.UbahUmatLingkungan');
    Route::get('/umat/DownloadExcelLingkungan', [UmatController::class, 'DownloadExcelLingkungan'])->name('umat.DownloadExcelLingkungan');
    Route::get('/umat/DownloadExcelKbg', [UmatController::class, 'DownloadExcelKbg'])->name('umat.DownloadExcelKbg');
    Route::post('/umat/ImportUmatLingkungan', [UmatController::class, 'ImportUmatLingkungan'])->name('umat.ImportUmatLingkungan');
    Route::post('/umat/ImportUmatKbg', [UmatController::class, 'ImportUmatKbg'])->name('umat.ImportUmatKbg');

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
    Route::post('/user/EditFormKL', [UserController::class, 'EditFormKL'])->name('user.EditFormKL');

    //Tambah Akun Ketua KBG
    Route::get('userKKBG', [UserController::class, 'DaftarKKBG'])->name('user.kkbg');
    Route::post('/user/TambahKKBG', [UserController::class, 'TambahKKBG'])->name('user.TambahKKBG');
    Route::post('/user/TambahAllKKBG', [UserController::class, 'TambahAllKKBG'])->name('user.TambahAllKKBG');
    Route::post('/user/EditFormKKBG', [UserController::class, 'EditFormKKBG'])->name('user.EditFormKKBG');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    //Keluarga
    Route::resource('keluargas', KeluargaController::class);

    //Baptis Bayi
    Route::resource('baptis', BaptisController::class);
    Route::post('/baptis/EditForm', [BaptisController::class, 'EditForm'])->name('baptis.EditForm');
    Route::get('/baptis/OpenForm/{id}', [BaptisController::class, 'OpenForm'])->name('baptis.OpenForm');
    Route::post('/baptis/Pembatalan', [BaptisController::class, 'Pembatalan'])->name('baptis.Pembatalan');

    //Baptis Dewasa
    Route::resource('baptisdewasa', BaptisDewasaController::class);
    Route::get('/baptisdewasa/OpenForm/{id}', [BaptisDewasaController::class, 'OpenForm'])->name('baptisdewasa.OpenForm');

    //Komuni Pertama
    Route::resource('komunipertama', KomuniPertamaController::class);
    Route::post('/komunipertama/EditForm', [KomuniPertamaController::class, 'EditForm'])->name('komunipertama.EditForm');
    Route::get('/komunipertama/OpenForm/{id}', [KomuniPertamaController::class, 'OpenForm'])->name('komunipertama.OpenForm');
    Route::post('/komunipertama/Pembatalan', [KomuniPertamaController::class, 'Pembatalan'])->name('komunipertama.Pembatalan');

    //Krisma
    Route::resource('krisma', KrismaController::class);
    Route::post('/krisma/EditForm', [KrismaController::class, 'EditForm'])->name('krisma.EditForm');
    Route::post('/krisma/EditForm2', [KrismaController::class, 'EditForm2'])->name('krisma.EditForm2');
    Route::get('/krisma/OpenForm/{id}', [KrismaController::class, 'OpenForm'])->name('krisma.OpenForm');
    Route::post('/krisma/InputFormSetempat', [KrismaController::class, 'InputFormSetempat'])->name('krisma.InputFormSetempat');
    Route::post('/krisma/PembatalanSetempat', [KrismaController::class, 'PembatalanSetempat'])->name('krisma.PembatalanSetempat');
    Route::post('/krisma/InputFormLintas', [KrismaController::class, 'InputFormLintas'])->name('krisma.InputFormLintas');
    Route::post('/krisma/PembatalanLintas', [KrismaController::class, 'PembatalanLintas'])->name('krisma.PembatalanLintas');

    //KPP
    Route::resource('kpp', KppController::class);
    Route::get('/kpp/OpenForm/{id}', [KppController::class, 'OpenForm'])->name('kpp.OpenForm');
    Route::get('/kpp/EditForm/{id}', [KppController::class, 'EditForm'])->name('kpp.EditForm');
    Route::get('/kpp/RiwayatKpp/{id}', [KppController::class, 'RiwayatKpp'])->name('kpp.RiwayatKpp');


    //Perkawinan
    Route::resource('perkawinan', PerkawinanController::class);
    Route::get('/perkawinan/RiwayatPerkawinan/{id}', [PerkawinanController::class, 'RiwayatPerkawinan'])->name('perkawinan.RiwayatPerkawinan');
    Route::get('/perkawinan/EditForm/{id}', [PerkawinanController::class, 'EditForm'])->name('perkawinan.EditForm');

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

    
    // MIDDLEWARE AUTH LOGIN
    Route::middleware(['auth'])->group(function(){
        //Permohonan Pelayanan
        Route::resource('pelayananlainnya', PelayananLainnyaController::class);
        Route::post('/pelayananlainnya/InputForm', [PelayananLainnyaController::class, 'InputForm'])->name('pelayananlainnya.InputForm');
        Route::post('/pelayananlainnya/InputFormAll', [PelayananLainnyaController::class, 'InputFormAll'])->name('pelayananlainnya.InputFormAll');
        Route::post('/pelayananlainnya/Pembatalan', [PelayananLainnyaController::class, 'Pembatalan'])->name('pelayananlainnya.Pembatalan');
        Route::post('/pelayananlainnya/detail', [PelayananLainnyaController::class, 'detail'])->name('pelayananlainnya.detail');

        //Pendaftaran Umat
        Route::resource('pendaftaranumat', PendaftaranUmatController::class);
        Route::post('/pendaftaranumat/InputFormLama', [PendaftaranUmatController::class, 'InputFormLama']);
        Route::post('/pendaftaranumat/InputFormBaru', [PendaftaranUmatController::class, 'InputFormBaru']);
        Route::post('/pendaftaranumat/InputFormBaru', [PendaftaranUmatController::class, 'InputFormBaru']);
        Route::post('/fetchkbg', [PendaftaranUmatController::class, 'fetchkbg'])->name('fetchkbg');
        Route::post('/fetchkbgbaru', [PendaftaranUmatController::class, 'fetchkbgbaru'])->name('fetchkbgbaru');
        Route::post('/pendaftaranumat/Pembatalan', [PendaftaranUmatController::class, 'Pembatalan']);

        //Pendaftaran Petugas Liturgi
        Route::resource('pendaftaranpetugas', PendaftaranPetugasController::class);
        Route::get('/pendaftaranpetugas/OpenForm/{id}', [PendaftaranPetugasController::class, 'OpenForm'])->name('pendaftaranpetugas.OpenForm');
        Route::post('/pendaftaranpetugas/InputForm', [PendaftaranPetugasController::class, 'InputForm'])->name('pendaftaranpetugas.InputForm');
        Route::post('/pendaftaranpetugas/Pembatalan', [PendaftaranPetugasController::class, 'Pembatalan'])->name('pendaftaranpetugas.Pembatalan');
        Route::post('/pendaftaranpetugas/detail', [PendaftaranPetugasController::class, 'detail'])->name('pendaftaranpetugas.detail');

        //Pendaftaran Baptis Bayi
        Route::resource('pendaftaranbaptis', PendaftaranBaptisController::class);
        Route::post('/pendaftaranbaptis/InputForm', [PendaftaranBaptisController::class, 'InputForm'])->name('pendaftaranbaptis.InputForm');
        Route::get('/pendaftaranbaptis/OpenForm/{id}', [PendaftaranBaptisController::class, 'OpenForm'])->name('pendaftaranbaptis.OpenForm');
        Route::post('/pendaftaranbaptis/Pembatalan', [PendaftaranBaptisController::class, 'Pembatalan'])->name('pendaftaranbaptis.Pembatalan');
        Route::post('/pendaftaranbaptis/detail', [PendaftaranBaptisController::class, 'detail'])->name('pendaftaranbaptis.detail');
        Route::post('/pendaftaranbaptis/EditForm', [PendaftaranBaptisController::class, 'EditForm'])->name('pendaftaranbaptis.EditForm');

        //Pendaftaran Baptis Dewasa
        Route::get('pendaftaranbaptisdewasa', [PendaftaranBaptisController::class, 'indexDewasa'])->name('pendaftaranbaptis.indexDewasa');
        Route::post('/pendaftaranbaptis/InputFormDewasa', [PendaftaranBaptisController::class, 'InputFormDewasa'])->name('pendaftaranbaptis.InputFormDewasa');
        Route::get('/pendaftaranbaptis/OpenFormDewasa/{id}', [PendaftaranBaptisController::class, 'OpenFormDewasa'])->name('pendaftaranbaptis.OpenFormDewasa');
        Route::post('/pendaftaranbaptis/detailDewasa', [PendaftaranBaptisController::class, 'detailDewasa'])->name('pendaftaranbaptis.detailDewasa');
        Route::post('/pendaftaranbaptis/EditFormDewasa', [PendaftaranBaptisController::class, 'EditFormDewasa'])->name('pendaftaranbaptis.EditFormDewasa');

        //Pendaftaran Komuni
        Route::resource('pendaftarankomuni', PendaftaranKomuniController::class);
        Route::post('/pendaftarankomuni/InputForm', [PendaftaranKomuniController::class, 'InputForm'])->name('pendaftarankomuni.InputForm');
        Route::get('/pendaftarankomuni/OpenForm/{id}', [PendaftaranKomuniController::class, 'OpenForm'])->name('pendaftarankomuni.OpenForm');
        Route::post('/pendaftarankomuni/detail', [PendaftaranKomuniController::class, 'detail'])->name('pendaftarankomuni.detail');

        //Pendaftaran Krisma
        Route::resource('pendaftarankrisma', PendaftaranKrismaController::class);
        Route::post('/pendaftarankrisma/InputFormSetempat', [PendaftaranKrismaController::class, 'InputFormSetempat'])->name('pendaftarankrisma.InputFormSetempat');
        Route::post('/pendaftarankrisma/InputFormLintas', [PendaftaranKrismaController::class, 'InputFormLintas'])->name('pendaftarankrisma.InputFormLintas');
        Route::get('/pendaftarankrisma/OpenForm/{id}', [PendaftaranKrismaController::class, 'OpenForm'])->name('pendaftarankrisma.OpenForm');
        Route::post('/pendaftarankrisma/detail', [PendaftaranKrismaController::class, 'detail'])->name('pendaftarankrisma.detail');

        //Pendaftaran Perkawinan
        Route::resource('pendaftaranperkawinan', PendaftaranPerkawinanController::class);
        Route::post('/pendaftaranperkawinan/detail', [PendaftaranPerkawinanController::class, 'detail'])->name('pendaftaranperkawinan.detail');
        Route::get('/pendaftaranperkawinan/EditForm/{id}', [PendaftaranPerkawinanController::class, 'EditForm'])->name('pendaftaranperkawinan.EditForm');

        //Pendaftaran KPP
        Route::resource('pendaftarankpp', PendaftaranKppController::class);
        Route::get('/pendaftarankpp/OpenForm/{id}', [PendaftaranKppController::class, 'OpenForm'])->name('pendaftarankpp.OpenForm');
        Route::post('/pendaftarankpp/InputForm', [PendaftaranKppController::class, 'InputForm'])->name('pendaftarankpp.InputForm');
        Route::post('/pendaftarankpp/detail', [PendaftaranKppController::class, 'detail'])->name('pendaftarankpp.detail');

        //Reservasi Misa
        Route::resource('reservasimisa', ReservasiMisaController::class);
        Route::post('/reservasimisa/PesanTiket', [ReservasiMisaController::class, 'PesanTiket'])->name('reservasimisa.PesanTiket');
        Route::post('/reservasimisa/Pembatalan', [ReservasiMisaController::class, 'Pembatalan'])->name('reservasimisa.Pembatalan');

        //Reservasi Tobat
        Route::resource('reservasitobat', ReservasiTobatController::class);
        Route::post('/reservasitobat/PesanTiket', [ReservasiTobatController::class, 'PesanTiket'])->name('reservasitobat.PesanTiket');
        Route::post('/reservasitobat/Pembatalan', [ReservasiTobatController::class, 'Pembatalan'])->name('reservasitobat.Pembatalan');
    });

    //Validasi Admin
    Route::get('validasiAdminPelayanan', [ValidasiAdminController::class, 'pelayanan'])->name('validasiAdmin.pelayanan');
    Route::post('/validasiAdmin/acceptpelayanan', [ValidasiAdminController::class, 'AcceptPelayanan'])->name('validasiAdmin.AcceptPelayanan');
    Route::post('/validasiAdmin/declinepelayanan', [ValidasiAdminController::class, 'DeclinePelayanan'])->name('validasiAdmin.DeclinePelayanan');
    Route::post('/validasiAdmin/pembatalanpelayanan', [ValidasiAdminController::class, 'PembatalanPelayanan'])->name('validasiAdmin.PembatalanPelayanan');

    Route::get('validasiAdminPetugas', [ValidasiAdminController::class, 'petugas'])->name('validasiAdmin.petugas');
    Route::post('/validasiAdmin/acceptpetugas', [ValidasiAdminController::class, 'AcceptPetugas'])->name('validasiAdmin.AcceptPetugas');
    Route::post('/validasiAdmin/declinepetugas', [ValidasiAdminController::class, 'DeclinePetugas'])->name('validasiAdmin.DeclinePetugas');

    Route::get('validasiAdminBaptis', [ValidasiAdminController::class, 'baptis'])->name('validasiAdmin.baptis');
    Route::get('validasiAdminBaptisDewasa', [ValidasiAdminController::class, 'baptisDewasa'])->name('validasiAdmin.baptisDewasa');
    Route::post('/validasiAdmin/acceptbaptis', [ValidasiAdminController::class, 'AcceptBaptis'])->name('validasiAdmin.AcceptBaptis');
    Route::post('/validasiAdmin/declinebaptis', [ValidasiAdminController::class, 'DeclineBaptis'])->name('validasiAdmin.DeclineBaptis');
    Route::post('/validasiAdmin/pembatalanbaptis', [ValidasiAdminController::class, 'PembatalanBaptis'])->name('validasiAdmin.PembatalanBaptis');

    Route::get('validasiAdminKomuni', [ValidasiAdminController::class, 'komuni'])->name('validasiAdmin.komuni');
    Route::post('/validasiAdmin/acceptkomuni', [ValidasiAdminController::class, 'AcceptKomuni'])->name('validasiAdmin.AcceptKomuni');
    Route::post('/validasiAdmin/declinekomuni', [ValidasiAdminController::class, 'DeclineKomuni'])->name('validasiAdmin.DeclineKomuni');
    Route::post('/validasiAdmin/pembatalankomuni', [ValidasiAdminController::class, 'PembatalanKomuni'])->name('validasiAdmin.PembatalanKomuni');
    Route::get('validasiAdminKursusKomuni', [ValidasiAdminController::class, 'KursusKomuni'])->name('validasiAdmin.KursusKomuni');
    Route::get('/validasiAdminKursusKomuni/PendaftarKomuni/{id}', [ValidasiAdminController::class, 'PendaftarKomuni'])->name('validasiAdmin.PendaftarKomuni');
    Route::post('/validasiAdminKursusKomuni/LulusKursusKomuni', [ValidasiAdminController::class, 'LulusKursusKomuni'])->name('validasiAdmin.LulusKursusKomuni');

    Route::get('validasiAdminKrisma', [ValidasiAdminController::class, 'krisma'])->name('validasiAdmin.krisma');
    Route::post('/validasiAdmin/acceptkrismasetempat', [ValidasiAdminController::class, 'AcceptKrismaSetempat'])->name('validasiAdmin.AcceptKrismaSetempat');
    Route::post('/validasiAdmin/declinekrismasetempat', [ValidasiAdminController::class, 'DeclineKrismaSetempat'])->name('validasiAdmin.DeclineKrismaSetempat');
    Route::post('/validasiAdmin/pembatalankrismasetempat', [ValidasiAdminController::class, 'PembatalanKrismaSetempat'])->name('validasiAdmin.PembatalanKrismaSetempat');
    Route::post('/validasiAdmin/acceptkrismalintas', [ValidasiAdminController::class, 'AcceptKrismaLintas'])->name('validasiAdmin.AcceptKrismaLintas');
    Route::post('/validasiAdmin/declinekrismalintas', [ValidasiAdminController::class, 'DeclineKrismaLintas'])->name('validasiAdmin.DeclineKrismaLintas');
    Route::post('/validasiAdmin/pembatalankrismalintas', [ValidasiAdminController::class, 'PembatalanKrismaLintas'])->name('validasiAdmin.PembatalanKrismaLintas');
    Route::get('validasiAdminKursusKrisma', [ValidasiAdminController::class, 'KursusKrisma'])->name('validasiAdmin.KursusKrisma');
    Route::get('/validasiAdminKursusKrisma/PendaftarKrisma/{id}', [ValidasiAdminController::class, 'PendaftarKrisma'])->name('validasiAdmin.PendaftarKrisma');
    Route::post('/validasiAdminKursusKrisma/LulusKursusKrisma', [ValidasiAdminController::class, 'LulusKursusKrisma'])->name('validasiAdmin.LulusKursusKrisma');

    Route::get('validasiAdminKpp', [ValidasiAdminController::class, 'kpp'])->name('validasiAdmin.kpp');
    Route::get('/validasiAdminKpp/DetailKpp/{id}', [ValidasiAdminController::class, 'DetailKpp'])->name('validasiAdmin.DetailKpp');
    Route::post('/validasiAdmin/acceptkpp', [ValidasiAdminController::class, 'AcceptKpp'])->name('validasiAdmin.AcceptKpp');
    Route::post('/validasiAdmin/declinekpp', [ValidasiAdminController::class, 'DeclineKpp'])->name('validasiAdmin.DeclineKpp');
    Route::post('/validasiAdminKpp/PembatalanKpp/{id}', [ValidasiAdminController::class, 'PembatalanKpp'])->name('validasiAdmin.PembatalanKpp');
    Route::get('validasiAdminKursusKpp', [ValidasiAdminController::class, 'KursusKpp'])->name('validasiAdmin.KursusKpp');
    Route::get('/validasiAdminKursusKpp/PendaftarKpp/{id}', [ValidasiAdminController::class, 'PendaftarKpp'])->name('validasiAdmin.PendaftarKpp');
    Route::post('/validasiAdminKursusKpp/LulusKursusKpp', [ValidasiAdminController::class, 'LulusKursusKpp'])->name('validasiAdmin.LulusKursusKpp');
    
    Route::get('validasiAdminPerkawinan', [ValidasiAdminController::class, 'perkawinan'])->name('validasiAdmin.perkawinan');
    Route::get('/validasiAdminPerkawinan/DetailPerkawinan/{id}', [ValidasiAdminController::class, 'DetailPerkawinan'])->name('validasiAdmin.DetailPerkawinan');
    Route::get('/validasiAdminPerkawinan/RiwayatPerkawinan/{id}', [ValidasiAdminController::class, 'RiwayatPerkawinan'])->name('validasiAdmin.RiwayatPerkawinan');
    Route::post('/validasiAdmin/acceptperkawinan', [ValidasiAdminController::class, 'AcceptPerkawinan'])->name('validasiAdmin.AcceptPerkawinan');
    Route::post('/validasiAdmin/declineperkawinan', [ValidasiAdminController::class, 'DeclinePerkawinan'])->name('validasiAdmin.DeclinePerkawinan');
    Route::post('/validasiAdminPerkawinan/PembatalanPerkawinan/{id}', [ValidasiAdminController::class, 'PembatalanPerkawinan'])->name('validasiAdmin.PembatalanPerkawinan');
    Route::post('/validasiAdminPerkawinan/EditForm', [ValidasiAdminController::class, 'EditForm'])->name('validasiAdmin.EditForm');
    Route::post('/validasiAdminPerkawinan/Update/{id}', [ValidasiAdminController::class, 'Update'])->name('validasiAdmin.Update');

    // validasi Kbg
    Route::get('validasiKbgPelayanan', [ValidasiKbgController::class, 'pelayanan'])->name('validasiKbg.pelayanan');
    Route::post('/validasiKbg/acceptpelayanan', [ValidasiKbgController::class, 'AcceptPelayanan'])->name('validasiKbg.AcceptPelayanan');
    Route::post('/validasiKbg/declinepelayanan', [ValidasiKbgController::class, 'DeclinePelayanan'])->name('validasiKbg.DeclinePelayanan');

    Route::get('validasiKbgBaptis', [ValidasiKbgController::class, 'baptis'])->name('validasiKbg.baptis');
    Route::get('validasiKbgBaptisDewasa', [ValidasiKbgController::class, 'baptisDewasa'])->name('validasiKbg.baptisDewasa');
    Route::post('/validasiKbg/acceptbaptis', [ValidasiKbgController::class, 'AcceptBaptis'])->name('validasiKbg.AcceptBaptis');
    Route::post('/validasiKbg/declinebaptis', [ValidasiKbgController::class, 'DeclineBaptis'])->name('validasiKbg.DeclineBaptis');

    Route::get('validasiKbgKomuni', [ValidasiKbgController::class, 'komuni'])->name('validasiKbg.komuni');
    Route::post('/validasiKbg/acceptkomuni', [ValidasiKbgController::class, 'AcceptKomuni'])->name('validasiKbg.AcceptKomuni');
    Route::post('/validasiKbg/declinekomuni', [ValidasiKbgController::class, 'DeclineKomuni'])->name('validasiKbg.DeclineKomuni');

    Route::get('validasiKbgKrisma', [ValidasiKbgController::class, 'krisma'])->name('validasiKbg.krisma');
    Route::post('/validasiKbg/acceptkrisma', [ValidasiKbgController::class, 'AcceptKrisma'])->name('validasiKbg.AcceptKrisma');
    Route::post('/validasiKbg/declinekrisma', [ValidasiKbgController::class, 'DeclineKrisma'])->name('validasiKbg.DeclineKrisma');


    // validasi KL
    Route::get('validasiKLUmatLama', [ValidasiKLController::class, 'umatLama'])->name('validasiKL.umatLama');
    Route::post('/validasiKL/acceptumatlama', [ValidasiKLController::class, 'AcceptUmatLama'])->name('validasiKL.AcceptUmatLama');
    Route::post('/validasiKL/declineumatlama', [ValidasiKLController::class, 'DeclineUmatLama'])->name('validasiKL.DeclineUmatLama');

    Route::get('validasiKLUmatBaru', [ValidasiKLController::class, 'umatBaru'])->name('validasiKL.umatBaru');
    Route::post('/validasiKL/acceptumatbaru', [ValidasiKLController::class, 'AcceptUmatBaru'])->name('validasiKL.AcceptUmatBaru');
    Route::post('/validasiKL/declineumatbaru', [ValidasiKLController::class, 'DeclineUmatBaru'])->name('validasiKL.DeclineUmatBaru');

    Route::get('validasiKLPelayanan', [ValidasiKLController::class, 'pelayanan'])->name('validasiKL.pelayanan');
    Route::post('/validasiKL/acceptpelayanan', [ValidasiKLController::class, 'AcceptPelayanan'])->name('validasiKL.AcceptPelayanan');
    Route::post('/validasiKL/declinepelayanan', [ValidasiKLController::class, 'DeclinePelayanan'])->name('validasiKL.DeclinePelayanan');

    Route::get('validasiKLBaptis', [ValidasiKLController::class, 'baptis'])->name('validasiKL.baptis');
    Route::get('validasiKLBaptisDewasa', [ValidasiKLController::class, 'baptisDewasa'])->name('validasiKL.baptisDewasa');
    Route::post('/validasiKL/acceptbaptis', [ValidasiKLController::class, 'AcceptBaptis'])->name('validasiKL.AcceptBaptis');
    Route::post('/validasiKL/declinebaptis', [ValidasiKLController::class, 'DeclineBaptis'])->name('validasiKL.DeclineBaptis');
    
    Route::get('validasiKLKomuni', [ValidasiKLController::class, 'komuni'])->name('validasiKL.komuni');
    Route::post('/validasiKL/acceptkomuni', [ValidasiKLController::class, 'AcceptKomuni'])->name('validasiKL.AcceptKomuni');
    Route::post('/validasiKL/declinekomuni', [ValidasiKLController::class, 'DeclineKomuni'])->name('validasiKL.DeclineKomuni');

    Route::get('validasiKLKrisma', [ValidasiKLController::class, 'krisma'])->name('validasiKL.krisma');
    Route::post('/validasiKL/acceptkrisma', [ValidasiKLController::class, 'AcceptKrisma'])->name('validasiKL.AcceptKrisma');
    Route::post('/validasiKL/declinekrisma', [ValidasiKLController::class, 'DeclineKrisma'])->name('validasiKL.DeclineKrisma');

    //Pemindahan Kbg
    Route::resource('pemindahankbg', PemindahanKbgController::class);
    Route::post('/pemindahanKBG/UpdateForm', [PemindahanKbgController::class, 'UpdateForm'])->name('pemindahanKBG.UpdateForm');

    //Complete Register
    Route::get('/complete-register', function () {
        return view('auth.complete-register');
    });

    Route::get('/auth/redirect', [UserController::class, 'redirect'])->name('auth.redirect');
    Route::post('/auth/complete-register', [UserController::class, 'complete_register'])->name('auth.complete-register');

    // LAPORAN
    Route::get('laporanBaptis', [LaporanController::class, 'baptis'])->name('laporan.baptis');
    Route::get('/laporanBaptis/DetailBaptis/{id}', [LaporanController::class, 'DetailBaptis'])->name('laporan.DetailBaptis');
    Route::get('laporanBaptisDewasa', [LaporanController::class, 'baptisDewasa'])->name('laporan.baptisDewasa');
    Route::get('laporanKomuni', [LaporanController::class, 'komuni'])->name('laporan.komuni');
    Route::get('laporanKrisma', [LaporanController::class, 'krisma'])->name('laporan.krisma');
    Route::get('laporanKpp', [LaporanController::class, 'kpp'])->name('laporan.kpp');
    Route::get('laporanPerkawinan', [LaporanController::class, 'perkawinan'])->name('laporan.perkawinan2');
    Route::post('/laporan/perkawinan', [LaporanController::class, 'perkawinan'])->name('laporan.perkawinan');


    // CETAK SERTIFIKAT
    Route::get('sertifikat/baptisbayi', [PendaftaranBaptisController::class, 'sertifikat_baptisbayi'])->name('listevent.sertifikat_baptisbayi');
    Route::get('sertifikat/baptisdewasa', [PendaftaranBaptisController::class, 'sertifikat_baptisdewasa'])->name('listevent.sertifikat_baptisdewasa');
    Route::get('sertifikat/komunipertama', [PendaftaranKomuniController::class, 'sertifikat_komunipertama'])->name('listevent.sertifikat_komunipertama');
    Route::get('sertifikat/krisma', [PendaftaranKrismaController::class, 'sertifikat_krisma'])->name('listevent.sertifikat_krisma');
    Route::get('sertifikat/perkawinan', [ListEventController::class, 'sertifikat_perkawinan'])->name('listevent.sertifikat_perkawinan');

});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});
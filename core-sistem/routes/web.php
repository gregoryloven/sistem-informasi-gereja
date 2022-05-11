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

    //Krisma
    Route::resource('krismas', KrismaController::class);

    //Misa
    Route::resource('misas', MisaController::class);
    Route::post('/misas/EditForm', [MisaController::class, 'EditForm'])->name('misas.EditForm');
    Route::get('/misas/DetailMisa/{id}', [MisaController::class, 'show'])->name('misas.DetailMisa');

});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

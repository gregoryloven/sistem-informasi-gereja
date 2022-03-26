<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParokiController;

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

    //Parkoki
    Route::resource('parokis', ParokiController::class);
    Route::post('/parokis/EditForm', [ParokiController::class, 'EditForm'])->name('parokis.EditForm');



});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

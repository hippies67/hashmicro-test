<?php

use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\InputCheckController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login/store', [LoginController::class, 'store'])->name('login.store');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('input-check', [InputCheckController::class, 'index'])->name('input-check.index');
    Route::post('input-check/store', [InputCheckController::class, 'store'])->name('input-check.store');


    Route::resource('pegawai', PegawaiController::class);
    Route::resource('departemen', DepartemenController::class);
    Route::resource('bonus', BonusController::class);

    Route::get('bonuses/load-data', [BonusController::class, 'load_bonus_data'])->name('bonus.load-data');
    Route::get('departemens/load-data', [DepartemenController::class, 'load_departemen_data'])->name('departemen.load-data');
    Route::get('pegawais/load-data', [PegawaiController::class, 'load_pegawai_data'])->name('pegawai.load-data');

});

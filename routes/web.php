<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\admin\GaleriController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KonsultasiController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PelayananPublikController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/informasi-publik', [InformasiPublikController::class, 'index'])->name('informasiPublik');
Route::get('/soon', [HomeController::class, 'coming_soon'])->name('404');
Route::post('/login', [LoginController::class, 'actionLogin'])->name('actionLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['prefix' => 'konsultasi', 'as' => 'konsultasi.', 'controller' => PelayananPublikController::class], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/get-data', 'getData')->name('getData');
    Route::post('/store', 'store')->name('store');
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'admin/dashboard', 'as' => 'admin.dashboard.', 'controller' => DashboardController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/upload', 'UploadBimbingan')->name('UploadBimbingan');
    });
});

    Route::group(['prefix' => 'admin/galeri', 'as' => 'admin.galeri.', 'controller' => GaleriController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/search', 'search')->name('search');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });

    Route::group(['prefix' => 'admin/user', 'as' => 'admin.user.', 'controller' => UserController::class], function () {
        Route::get('/', 'index')->name('index');
        // Route::post('/upload', 'UploadBimbingan')->name('UploadBimbingan');
        Route::get('/get-data', 'getData')->name('getData');
        Route::post('/store', 'tambahUser')->name('store');
        // Route::get('/edit/{id}', 'edit')->name('edit');
        // Route::post('/update', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
        // Route::get('/getNpp', 'getNppDosen')->name('getNppDosen');
    });

    Route::group(['prefix' => 'admin/berita', 'as' => 'admin.berita.', 'controller' => BeritaController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/get-data', 'getData')->name('getData');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');

        // Route::get('/getNpp', 'getNppDosen')->name('getNppDosen');
    });
    Route::group(['prefix' => 'admin/konsultasi', 'as' => 'admin.konsultasi.', 'controller' => KonsultasiController::class], function () {
        Route::get('/', 'index')->name('index');
        // Route::post('/upload', 'UploadBimbingan')->name('UploadBimbingan');
        Route::post('/store', 'storeJawaban')->name('store');
        Route::get('/get-data', 'getData')->name('getData');
        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::get('/search', 'search')->name('search');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });
    // storeJawaban
// });
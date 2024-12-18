<?php

use App\Http\Controllers\homeController;
use App\Http\Controllers\userController;
use App\Http\Controllers\produkController;
use App\Http\Controllers\transaksiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('home', homeController::class);
Route::resource('user', userController::class);
Route::resource('produk', produkController::class);
Route::resource('transaksi', transaksiController::class);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/check-email/{email}', [UserController::class, 'checkEmail']);
Route::post('/check-email', [UserController::class, 'checkEmail']);

Route::get('/check-kode-produk/{kode_produk}', [produkController::class, 'checkKodeProduk']);
Route::post('/check-kode-produk', [produkController::class, 'checkKodeProduk']);

Route::post('/transaksi', [TransaksiController::class, 'store']);

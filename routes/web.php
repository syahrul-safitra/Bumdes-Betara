<?php

use App\Http\Controllers\DokumentasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Customer.index');
});

Route::get('/profil', function () {
    return view('Customer.profile');
});

Route::get('/dokumentasi-desa', function () {
    return view('Customer.dokumentasi');
});

Route::get('/dokumentasi-desa/1', function () {
    return view('Customer.detail-dokumentasi');
});

Route::get('/rental', function () {
    return view('Customer.rental');
});

Route::get('/dashboard', function () {
    return view('Admin.Layouts.main');
});

Route::resource('/dokumentasi', DokumentasiController::class);

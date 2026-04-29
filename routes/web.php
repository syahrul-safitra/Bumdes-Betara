<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;
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

Route::get('/rental-kendaraan', function () {
    return view('Customer.rental', [
        'vehicles' => Vehicle::latest()->get(),
    ]);
});

Route::get('/dashboard', function () {
    return view('Admin.Layouts.main');
});

Route::resource('/dokumentasi', DokumentasiController::class);

Route::resource('/vehicle', VehicleController::class);

// ============= Customer ===========================
Route::get('/registrasi', function () {
    return view('Customer.registrasi');
});

Route::get('/create-rental', function () {
    return view('Customer.create-rental', [
        'car' => Vehicle::find(1),
    ]);
});

Route::post('/rental', [RentalController::class, 'store']);

Route::post('/register-customer', [CustomerController::class, 'store']);

Route::get('/detail-rental', [RentalController::class, 'detail']);

// ============= Login ==============================
Route::get('/login', function () {
    return view('login');
});

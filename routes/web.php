<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;

use App\Models\Dokumentasi;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\Customer;

use Illuminate\Support\Facades\Route;

use illuminate\Support\Facades\Auth;


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

Route::get('/dashboard', function () {
    return view('Admin.dashboard', [
        'total_berita_bln_ini' => Dokumentasi::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count(), 
        'total_unit_kendaraan' => Vehicle::count(),
        'total_rental_aktif' => Rental::where('status_rental', 'sedang_dipinjam')->count(),
        'total_customer' => Customer::count()
    ]);
});

Route::resource('/dokumentasi', DokumentasiController::class);

Route::resource('/vehicle', VehicleController::class);

Route::resource('/rental', RentalController::class);

Route::resource('/customer', CustomerController::class);

Route::post('/set-pembayaran/{rental}', [RentalController::class, 'setPembayaran']);
Route::post('/set-status/{rental}', [RentalController::class, 'setStatus']);

Route::post('/laporan', [RentalController::class, 'laporan']);

// ============= Customer ===========================
Route::get('/registrasi', function () {
    return view('Customer.registrasi');
});

Route::get('/create-rental/{vehicle}', [RentalController::class, 'create']);

Route::post('/rental', [RentalController::class, 'store']);

Route::post('/register-customer', [CustomerController::class, 'store']);

Route::get('/detail-rental/{rental}', [RentalController::class, 'detail']);
Route::post('/upload-pembayaran/{rental}', [RentalController::class, 'uploadPembayaran']);

Route::get('/', function () {
    return view('Customer.index');
});

Route::get('/profil', function () {
    return view('Customer.profile');
});

Route::get('/dokumentasi-desa', function () {
    return view('Customer.dokumentasi', [
        'dokumentasis' => Dokumentasi::orderBy('tanggal')->get()
    ]);
});

Route::get('/riwayat-sewa', [RentalController::class, 'riwayat']);

Route::get('/dokumentasi-desa/{dokumentasi}', [DokumentasiController::class, 'show']);

Route::get('/rental-kendaraan', function () {
    return view('Customer.rental', [
        'vehicles' => Vehicle::latest()->get(),
    ]);
});

// ============= Authentication ==============================
Route::post('/authentication', [AuthController::class, 'authentication']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/login', [AuthController::class, 'login']);

Route::get("/test1", function(){ 
    return Auth::guard('admin')->user();
});

Route::get("/test2", function(){ 
    return Auth::guard('customer')->user();
});
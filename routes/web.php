<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use App\Models\Dokumentasi;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\Customer;

use GuzzleHttp\Middleware;
use Illuminate\Broadcasting\Broadcasters\UsePusherChannelConventions;
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
})->middleware('isAdmin');

Route::resource('/dokumentasi', DokumentasiController::class)->middleware('isAdmin');

Route::resource('/vehicle', VehicleController::class)->middleware('isAdmin');

Route::resource('/rental', RentalController::class);

Route::resource('/customer', CustomerController::class)->middleware('isAdmin');

Route::post('/set-pembayaran/{rental}', [RentalController::class, 'setPembayaran'])->middleware('isAdmin');
Route::post('/set-status/{rental}', [RentalController::class, 'setStatus'])->middleware('isAdmin');

Route::post('/laporan', [RentalController::class, 'laporan'])->middleware('isAdmin');

Route::get('/admin', [AdminController::class, 'index'])->middleware('isAdmin');
Route::get('/admin/{admin}/edit', [AdminController::class, 'edit'])->middleware('isAdmin');
Route::put('/admin/{admin}', [AdminController::class, 'update'])->middleware('isAdmin');

// ============= Customer ===========================
Route::get('/registrasi', function () {

    if (Auth::guard('admin')->check() || Auth::guard('admin')->check()) {
        return redirect('/');
    }
    return view('Customer.registrasi');

});

Route::get('/create-rental/{vehicle}', [RentalController::class, 'create'])->middleware('isCustomer');

Route::post('/rental', [RentalController::class, 'store'])->middleware('isCustomer');

Route::post('/register-customer', [CustomerController::class, 'store'])->middleware('isCustomer');

Route::get('/detail-rental/{rental}', [RentalController::class, 'detail'])->middleware('isCustomer');
Route::post('/upload-pembayaran/{rental}', [RentalController::class, 'uploadPembayaran'])->middleware('isCustomer');


Route::get('/riwayat-sewa', [RentalController::class, 'riwayat'])->middleware('isCustomer');
Route::get('/rental-kendaraan', function () {
    return view('Customer.rental', [
        'vehicles' => Vehicle::latest()->get(),
    ]);
})->middleware('isCustomer');
// ======================================= Guest ==============================================

Route::get('/', function () {
    if (Auth::guard("admin")->check()) {
        return redirect('/dashboard');
    }
    return view('Customer.index');
});

Route::get('/profil', function () {
    if (Auth::guard("admin")->check()) {
        return redirect('/dashboard');
    }
    
    return view('Customer.profile');
});

Route::get('/dokumentasi-desa', function () {
    if (Auth::guard("admin")->check()) {
        return redirect('/dashboard');
    }
    
    return view('Customer.dokumentasi', [
        'dokumentasis' => Dokumentasi::orderBy('tanggal')->paginate(6)
    ]);
});

Route::get('/dokumentasi-desa/{dokumentasi}', [DokumentasiController::class, 'show']);

// ============= Authentication ==============================
Route::post('/authentication', [AuthController::class, 'authentication']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/login', [AuthController::class, 'login']);

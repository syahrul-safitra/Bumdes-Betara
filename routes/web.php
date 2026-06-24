<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SppGroupController;
use App\Http\Controllers\SppLoanController;
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

use App\Models\SppLoan;
use App\Models\SppInstallment;
use Carbon\Carbon;

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

    $totalModalBerputar = SppLoan::whereIn('status_loan', ['disetujui', 'berjalan'])->sum('plafon_disetujui');

    // 2. Hitung akumulasi denda yang sudah sukses dibayarkan/masuk kas dari tabel angsuran
    $totalDendaMasuk = SppInstallment::where('status_bayar', 'lunas')->sum('denda_kumulatif');

    // 3. Ambil semua angsuran yang belum bayar dan sudah melewati tanggal jatuh tempo hari ini
    $today = Carbon::now()->toDateString();
    $lateInstallments = SppInstallment::with(['loan.group'])
        ->where('status_bayar', 'belum_bayar')
        ->where('tanggal_jatuh_tempo', '<', $today)
        ->get();

    // 4. Cari tahu berapa banyak kelompok unik yang saat ini sedang menunggak
    $jumlahKelompokMenunggak = $lateInstallments->pluck('loan.group_id')->unique()->count();

    // 5. Hitung estimasi total denda berjalan yang belum dibayar di lapangan saat ini
    $totalDendaBerjalan = 0;
    foreach ($lateInstallments as $ins) {
        $selisihHari = Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(Carbon::now());
        $totalDendaBerjalan += ($selisihHari * 5000); // Tarif Rp 5.000/hari
    }

    // 6. Ambil 5 riwayat aktivitas pinjaman terbaru untuk tabel aktivitas
    $recentLoans = SppLoan::with('group')
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();

    return view('Admin.dashboard', [
        'total_berita_bln_ini' => Dokumentasi::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count(), 
        'total_unit_kendaraan' => Vehicle::count(),
        'total_rental_aktif' => Rental::where('status_rental', 'sedang_dipinjam')->count(),
        'total_customer' => Customer::count(),
        'totalModalBerputar' => $totalModalBerputar,
        'totalDendaMasuk' => $totalDendaMasuk,
        'totalDendaBerjalan' => $totalDendaBerjalan,
        'jumlahKelompokMenunggak' => $jumlahKelompokMenunggak,
        'lateInstallments' => $lateInstallments,
        'recentLoans' => $recentLoans
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

// ============= Peminjaman =============================================================
Route::get('/spp-group', [SppGroupController::class, 'index']);

Route::controller(SppGroupController::class)->group(function() {
    Route::get('/spp-group/create', 'create')->middleware('isAdmin');
    Route::post('/spp-group', 'store')->middleware('isAdmin');
    Route::get('/spp-group/{group}', 'show')->middleware('isAdmin');
    Route::get('/spp-group/{group}/edit', 'edit')->middleware('isAdmin');
    Route::put('/spp-group/{group}', 'update')->middleware('isAdmin');
});

Route::controller(SppLoanController::class)->group(function() {
    
    // ============================= REVISI ================================
    Route::get('/spp-loan', 'index')->middleware('isAdmin');
    Route::put('/spp-loan-approve/{loan}', 'approve')->middleware('isAdmin');
    Route::put('/spp-loan-reject/{loan}', 'reject')->middleware('isAdmin');
    Route::get('/spp-loan/{loan}', 'show')->middleware('isAdmin');
    Route::put('/spp-loan-pay/{installmentId}', 'payInstallment')->middleware('isAdmin');
    Route::put('/spp-loan-cair2/{loan}', 'disburseTahap2')->middleware('isAdmin');
    Route::get('/spp-installment/{id}/receipt', [SppLoanController::class, 'printReceipt'])->middleware('isAdmin'); 
    Route::get('/spp-loan/{id}/report', [SppLoanController::class, 'printLoanReport'])->middleware('isAdmin'); 

    Route::get('/spp-loan/create', 'create')->middleware('isAdmin');
    Route::post('/spp-loan', 'store')->middleware('isAdmin');
    Route::get('/spp-loan/{loan}', 'show')->middleware('isAdmin');
    Route::post('/spp-loan/{loan}/disburse', 'disburse')->middleware('isAdmin');
    // Route::get('/spp-installment/{id}/receipt', [SppLoanController::class, 'printReceipt'])->middleware('isAdmin');
    Route::get('/spp-loan/{id}/report', [SppLoanController::class, 'singleLoanReport'])->middleware('isAdmin');
    
    // Dana awal 
    Route::post('/spp-loan/{loan}/disburse', [SppLoanController::class, 'disburse'])->middleware('isAdmin');
    Route::post('/spp-loan/{loan}/disburse-next', [SppLoanController::class, 'disburseNext'])->middleware('isAdmin');
    Route::post('/spp-installment/{id}/pay', [SppLoanController::class, 'payInstallment'])->middleware('isAdmin');
});



// ============= Customer ===========================
Route::get('/registrasi', function () {

    if (Auth::guard('admin')->check() || Auth::guard('admin')->check() || Auth::guard('spp')->check()) {
        return redirect('/');
    }
    return view('Customer.registrasi');

});

Route::get('/create-rental/{vehicle}', [RentalController::class, 'create'])->middleware('isCustomer');
Route::get('/create-rental-bulanan/{vehicle}', [RentalController::class, 'createPerbulan'])->middleware('isCustomer');

Route::post('/rental', [RentalController::class, 'store'])->middleware('isCustomer');
Route::post('/rental-bulanan', [RentalController::class, 'storeBulanan'])->middleware('isCustomer');

Route::post('/register-customer', [CustomerController::class, 'store']);

Route::get('/detail-rental/{rental}', [RentalController::class, 'detail'])->middleware('isCustomer');
// Route::post('/upload-pembayaran/{rental}', [RentalController::class, 'uploadPembayaran'])->middleware('isCustomer');
Route::post('/upload-identitas/{rental}', [RentalController::class, 'uploadIdentitas'])->middleware('isCustomer');


Route::get('/riwayat-sewa', [RentalController::class, 'riwayat'])->middleware('isCustomer');
Route::get('/rental-kendaraan', function () {
    return view('Customer.rental', [
        'vehicles' => Vehicle::where('is_ready', 1)->get(),
    ]);
});     
// ======================================= Guest ==============================================

Route::get('/', function () {
    if (Auth::guard("admin")->check()) {
        return redirect('/dashboard');
    }

    if (Auth::guard("spp")->check()) {
        return redirect('/spp-dashboard');
    }

    return view('Customer.index', [
        'dokumentasis' => Dokumentasi::orderBy('tanggal', 'desc')->paginate(6)
    ]);
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
        'dokumentasis' => Dokumentasi::orderBy('tanggal', 'desc')->paginate(6)
    ]);
});

Route::get('/dokumentasi-desa/{dokumentasi}', [DokumentasiController::class, 'show']);

// ============= Authentication ==============================
Route::post('/authentication', [AuthController::class, 'authentication']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/login', [AuthController::class, 'login']);

Route::get('/test', function() {
    return view('Admin.SPP.show_loan');
});

// ============= SPP (Customer) ===========================================
Route::get('/registrasi-spp', function(){ 

    if (Auth::guard('admin')->check() || Auth::guard('admin')->check() || Auth::guard('spp')->check()) {
        return redirect('/');
    }

    return view('SPPMember.registrasi');
});

Route::post('/registrasi-spp', [SppGroupController::class, 'storeRegistrasiSpp']);

Route::get('/spp-dashboard', [SppGroupController::class, 'sppDashboard'])->middleware('isSpp');
Route::get('/spp-group-rev', [SppGroupController::class, 'sppGroupRev'])->middleware('isSpp');
Route::put('/spp-group-rev-update/{group}', [SppGroupController::class, 'sppGroupRevUpdate'])->middleware('isSpp');
Route::post('/spp-group-rev-member', [SppGroupController::class, 'sppGroupMember'])->middleware('isSpp');
Route::put('/spp-group-rev-member/{member}', [SppGroupController::class, 'sppGroupMemberUpdate'])->middleware('isSpp');
Route::delete('/spp-group-rev-member/{member}', [SppGroupController::class, 'sppGroupMemberDelete'])->middleware('isSpp');

Route::get('/spp-group-loan', [SppLoanController::class, 'sppLoan'])->middleware('isSpp');
Route::post('/spp-group-loan', [SppLoanController::class, 'storeLoan'])->middleware('isSpp');

Route::get('/spp-group-all', [SppLoanController::class, 'sppLoanAll'])->middleware('isSpp');
Route::get('/spp-group-all/{loan}', [SppLoanController::class, 'showLoan'])->middleware('isSpp');
Route::post('/spp-group-payloan/{installment}', [SppLoanController::class, 'payInstallmentRev'])->middleware('isSpp');
// =========================================================================

// ================== SPP ADMIN ============================================
Route::get('/spp-group-admin', [SppGroupController::class, 'allGroup']);
Route::get('/spp-group-admin/{group}/show', [SppGroupController::class, 'showGroup']);
Route::put('/spp-group-admin/{group}/approve', [SppGroupController::class, 'approve']);
Route::put('/spp-group-admin/{group}/reject', [SppGroupController::class, 'reject']);

// =========================================================================

// ===================== Login SPP =========================================
Route::get("/login-spp", [AuthController::class, 'loginSpp']);
Route::post("/login-spp", [AuthController::class, 'authenticationSpp']);
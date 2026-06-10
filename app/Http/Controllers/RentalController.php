<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');

        $rentals = Rental::with(['customer', 'vehicle'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    // Cari di tabel Customer
                    $q->whereHas('customer', function ($c) use ($search) {
                        $c->where('nama', 'like', '%' . $search . '%');
                    })
                    // Atau cari di tabel Vehicle (Armada)
                    ->orWhereHas('vehicle', function ($v) use ($search) {
                        $v->where('merek', 'like', '%' . $search . '%');
                    });
                });
            })
                ->latest()
                ->paginate(10)
                ->withQueryString();


        return view('Admin.Rental.index', [
            'rentals' => $rentals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Vehicle $vehicle)
    {
        return view('Customer.create-rental', [
            'car' => $vehicle,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'customer_id' => 'required',
    //         'vehicle_id' => 'required',
    //         'sewa_driver' => 'required',
    //         'tanggal_peminjaman' => 'required|after_or_equal:today',
    //         'tanggal_pengembalian' => 'required|after_or_equal:today',
    //     ]);

    //     $tanggal_peminjaman = $validated['tanggal_peminjaman'];
    //     $tanggal_pengembalian = $validated['tanggal_pengembalian'];

    //     $checkRental = Rental::where('vehicle_id', $validated['vehicle_id'])
    //         ->where(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
    //             $query->whereBetween('tanggal_peminjaman', [$tanggal_peminjaman, $tanggal_pengembalian])
    //                 ->orWhereBetween('tanggal_pengembalian', [$tanggal_peminjaman, $tanggal_pengembalian]);
    //         })

    //         ->orWhere(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
    //             $query->where('tanggal_peminjaman', '<', $tanggal_peminjaman)
    //                 ->where('tanggal_pengembalian', '>', $tanggal_pengembalian);
    //         });

    //     $conflictResult = $checkRental->exists();

    //     if ($conflictResult) {
    //         return back()
    //             ->withInput() // Menjaga agar input tanggal tidak hilang
    //             ->withErrors(['tanggal_peminjaman' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.', 'tanggal_pengembalian' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.']);
    //     }

    //     // cek total sewa :
    //     $tanggalAwal = Carbon::parse($tanggal_peminjaman);

    //     $tanggalAkhir = Carbon::parse($tanggal_pengembalian);

    //     $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

    //     $vehicle = Vehicle::find($validated['vehicle_id']);

    //     $totalHarga = $selisihHari * $vehicle->harga_perhari;

    //     $validated['total_sewa'] = $totalHarga;

    //     $getDataRental = Rental::create($validated);

    //     return redirect('/detail-rental/'.$getDataRental->id)->with('success', 'Berhasil booking kendaraan, silahkan melakukan pembayaran');

    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'          => 'required',
            'vehicle_id'           => 'required|exists:vehicles,id',
            'sewa_driver'          => 'required|in:0,1', // Validasi input radio driver (0 atau 1)
            'tanggal_peminjaman'   => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman', // Memastikan tgl kembali tidak mendahului tgl pinjam
        ]);

        $tanggal_peminjaman = $validated['tanggal_peminjaman'];
        $tanggal_pengembalian = $validated['tanggal_pengembalian'];
        $vehicleId = $validated['vehicle_id'];

        // Cek ketersediaan jadwal (Sudah diperbaiki agar skope pengecekan terkunci pada ID mobil ini saja)
        $conflictResult = Rental::where('vehicle_id', $vehicleId)
            ->where(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                $query->where(function ($q) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                    $q->whereBetween('tanggal_peminjaman', [$tanggal_peminjaman, $tanggal_pengembalian])
                    ->orWhereBetween('tanggal_pengembalian', [$tanggal_peminjaman, $tanggal_pengembalian]);
                })
                ->orWhere(function ($q) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                    $q->where('tanggal_peminjaman', '<', $tanggal_peminjaman)
                    ->where('tanggal_pengembalian', '>', $tanggal_pengembalian);
                });
            })->exists();

        if ($conflictResult) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal_peminjaman' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.', 
                    'tanggal_pengembalian' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.'
                ]);
        }

        // 1. Hitung durasi hari rental
        $tanggalAwal = Carbon::parse($tanggal_peminjaman);
        $tanggalAkhir = Carbon::parse($tanggal_pengembalian);
        $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

        // 2. Ambil data kendaraan dari database
        $vehicle = Vehicle::findOrFail($vehicleId);

        // 3. Logika Kalkulasi Total Harga (Harga Mobil + Opsional Jasa Driver)
        $hargaMobil = $selisihHari * $vehicle->harga_perhari;
        $hargaDriver = 0;

        // Jika input sewa_driver bernilai 1 (True / Pakai Driver)
        if ($validated['sewa_driver'] == 1) {
            $hargaDriver = $selisihHari * $vehicle->sewa_driver; // Menggunakan kolom sewa_driver dari tabel vehicle
        }

        // Gabungkan akumulasi biaya
        $totalHarga = $hargaMobil + $hargaDriver;

        // 4. Masukkan hasil kalkulasi ke array validated sebelum di-create
        $validated['total_sewa'] = $totalHarga;

        // 5. Eksekusi penyimpanan data transaksi
        $getDataRental = Rental::create($validated);

        return redirect('/detail-rental/' . $getDataRental->id)->with('success', 'Berhasil booking kendaraan, silahkan melakukan pembayaran');
    }


    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {

        $tanggalAwal = Carbon::parse($rental->tanggal_peminjaman);

        $tanggalAkhir = Carbon::parse($rental->tanggal_pengembalian);

        $hariIni = Carbon::now();

        $telat = 0;
        $denda = 0;

        // Cek apakah sudah dikembalikan :
        if ($rental->tanggal_dikembalikan) {

            // Jika sudah dikembalikan apakah ada telat :
            $tanggalDikembalikan = Carbon::parse($rental->tanggal_dikembalikan);

            $tanggalDikembalikan->diffInDays($tanggalAkhir, false);

            if ($tanggalDikembalikan->diffInDays($tanggalAkhir, false) < 0) {
                $telat = $tanggalDikembalikan->diffInDays($tanggalAkhir, false);

                if ($rental->sewa_driver) {
                    $denda = ($telat * -1) * ($rental->vehicle->denda_perhari + $rental->vehicle->sewa_driver);
                } else {
                    $denda = ($telat * -1) * $rental->vehicle->denda_perhari;
                }
            }

        // Jike Belum dikembalikan 
        } else {
            // cek apakah denda :
            if ($hariIni->diffInDays($tanggalAkhir, false) < 0) {

                $telat = $hariIni->diffInDays($tanggalAkhir, false);

                if ($rental->sewa_driver) {
                    $denda = ($telat * -1) * ($rental->vehicle->denda_perhari + $rental->vehicle->sewa_driver);
                } else {
                    $denda = ($telat * -1) * $rental->vehicle->denda_perhari;
                }

            }

        }

        $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

        // return $telat;

        return view('Admin.Rental.show', [
            'rental' => $rental->load('vehicle', 'customer'),
            'selisihHari' => $selisihHari,
            'totalHarga' => $selisihHari * $rental->vehicle->harga_perhari,
            'totalTelat' => $telat,
            'totalDenda' => $denda,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
                // hapus file lama :
        File::delete('File/'.$rental->bukti_pembayaran);

        $rental->delete();

        return back()->with('success', "Berhasil menghapus data rental");

    }

    public function detail(Rental $rental)
    {

        $no_telepon_admin = User::select('no_telepon')->where('id', 1)->get();

        $tanggalAwal = Carbon::parse($rental->tanggal_peminjaman);

        $tanggalAkhir = Carbon::parse($rental->tanggal_pengembalian);

        $hariIni = Carbon::now();

        $telat = 0;
        $denda = 0;

        // Cek apakah belum dikembalikan :
        if ($rental->tanggal_dikembalikan) {

            // Jika sudah dikembalikan apakah ada telat :
            $tanggalDikembalikan = Carbon::parse($rental->tanggal_dikembalikan);

            $tanggalDikembalikan->diffInDays($tanggalAkhir, false);

            if ($tanggalDikembalikan->diffInDays($tanggalAkhir, false) < 0) {
                $telat = $tanggalDikembalikan->diffInDays($tanggalAkhir, false);

                $denda = ($telat * -1) * $rental->vehicle->denda_perhari;
            }


        // Jika belum dikembalikan
        } else {
            // cek apakah denda :
            if ($hariIni->diffInDays($tanggalAkhir, false) < 0) {

                $telat = $hariIni->diffInDays($tanggalAkhir, false);

                if ($rental->sewa_driver) {
                    $denda = ($telat * -1) * ($rental->vehicle->denda_perhari + $rental->vehicle->sewa_driver);
                } else {
                    $denda = ($telat * -1) * $rental->vehicle->denda_perhari;
                }

            }

        }

        $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

        return view('Customer.detail-rental', [
            'rental' => $rental->load('customer', 'vehicle'),
            'selisihHari' => $selisihHari,
            'totalHarga' => $selisihHari * $rental->vehicle->harga_perhari,
            'totalTelat' => $telat,
            'totalDenda' => $denda,
            'noTeleponAdmin' => $no_telepon_admin[0]
        ]);
    }

    public function uploadPembayaran(Rental $rental, Request $request)
    {

        $validated = $request->validate([
            'bukti_pembayaran' => 'required|max:2100',
        ]);

        // hapus file lama :
        File::delete('File/'.$rental->bukti_pembayaran);

        $file = $request->file('bukti_pembayaran');

        $renameFile = time().'-'.$file->getClientOriginalName();

        $validated['bukti_pembayaran'] = $renameFile;

        $rental->update($validated);

        $file->move('File', $renameFile);

        return back()->with('success', 'Berhasil mengupload pembayaran');
    }

    public function uploadIdentitas(Rental $rental, Request $request)
    {

        $validated = $request->validate([
            'file_identitas' => 'max:2100',
            'alamat' => 'required|max:100',
        ]);

        if ($request->file('file_identitas')) {
            // hapus file lama :
            File::delete('File/'.$rental->file_identitas);

            $file = $request->file('file_identitas');

            $renameFile = time().'-'.$file->getClientOriginalName();

            $validated['file_identitas'] = $renameFile;

            $file->move('File', $renameFile);
        }
        
        $rental->update($validated);


        return back()->with('success', 'Berhasil mengupload file identitas');
    }

    public function setPembayaran(Request $request, Rental $rental)
    {

        $validated = $request->validate([
            'status_pembayaran' => 'required',
        ]);

        $rental->update($validated);

        return back()->with('success', 'Berhasil mengupdate status pembayaran');

    }

    public function setStatus(Request $request, Rental $rental)
    {

        $validated = $request->validate([
            'status_rental' => 'required',
        ]);

        if ($request->status_rental == 'telah_dikembalikan') {

            $tanggalAkhir = Carbon::parse($rental->tanggal_pengembalian);

            $hariIni = Carbon::now();

            $telat = 0;
            $denda = 0;

            // cek apakah denda :
            if ($hariIni->diffInDays($tanggalAkhir, false) < 0) {

                $telat = $hariIni->diffInDays($tanggalAkhir, false);

                // Jika terdapat sewa driver :
                if ($rental->sewa_driver) {
                    $denda = ($telat * -1) * ($rental->vehicle->denda_perhari + $rental->vehicle->sewa_driver);
                } else {
                    $denda = ($telat * -1) * $rental->vehicle->denda_perhari;
                }

            }

            $validated['total_denda'] = $denda;

            $validated['tanggal_dikembalikan'] = date('Y-m-d');

        }

        $rental->update($validated);

        return back()->with('success', 'Berhasil mengupdate status rental');

    }

    // public function laporan(Request $request)
    // {
    //     $getRental = Rental::with('vehicle', 'customer')->whereBetween('tanggal_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir])->get();

    //     $pdf = Pdf::loadView('Admin.laporan', [
    //         'tanggal_awal' => $request->tanggal_awal,
    //         'tanggal_akhir' => $request->tanggal_akhir,
    //         'rentals' => $getRental,
    //     ]);

    //     return $pdf->stream('invoice.pdf');
    // }

    public function laporan(Request $request)
    {
        // Mengambil data rental beserta relasinya berdasarkan range tanggal peminjaman
        $getRental = Rental::with('vehicle', 'customer')
            ->whereBetween('tanggal_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();

        $pdf = Pdf::loadView('Admin.laporan', [
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'rentals'      => $getRental,
        ]);

        return $pdf->stream('laporan-rental.pdf');
    }

    public function riwayat() {

        $customer = auth()->guard('customer')->user();

        return view('Customer.riwayat', [
            'customer' => $customer->load('rental.vehicle')
        ]);

    }
}

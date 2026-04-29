<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required',
            'vehicle_id' => 'required',
            'tanggal_peminjaman' => 'required|after_or_equal:today',
            'tanggal_pengembalian' => 'required|after_or_equal:today',
        ]);

        $tanggal_peminjaman = $validated['tanggal_peminjaman'];
        $tanggal_pengembalian = $validated['tanggal_pengembalian'];

        $checkRental = Rental::where('vehicle_id', $validated['vehicle_id'])
            ->where(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                $query->whereBetween('tanggal_peminjaman', [$tanggal_peminjaman, $tanggal_pengembalian])
                    ->orWhereBetween('tanggal_pengembalian', [$tanggal_peminjaman, $tanggal_pengembalian]);
            })

            ->orWhere(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                $query->where('tanggal_peminjaman', '<', $tanggal_peminjaman)
                    ->where('tanggal_pengembalian', '>', $tanggal_pengembalian);
            });

        $conflictResult = $checkRental->exists();

        if ($conflictResult) {
            return back()
                ->withInput() // Menjaga agar input tanggal tidak hilang
                ->withErrors(['tanggal_peminjaman' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.', 'tanggal_pengembalian' => 'Maaf, mobil sudah dipesan pada tanggal tersebut. Silakan pilih jadwal lain.']);
        }

        // cek total sewa :
        $tanggalAwal = Carbon::parse($tanggal_peminjaman);

        $tanggalAkhir = Carbon::parse($tanggal_pengembalian);

        $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

        $vehicle = Vehicle::find($validated['vehicle_id']);

        $totalHarga = $selisihHari * $vehicle->harga_perhari;

        $validated['total_sewa'] = $totalHarga;

        $getDataRental = Rental::create($validated);

        return 'Berhasil sewa';

        // return redirect('/rental/' . $getDataRental->id)->with('success', 'Berhasil booking kendaraan, silahkan melakukan pembayaran');

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
        //
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
        //
    }

    public function detail()
    {
        $rental = Rental::first();

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

                $denda = ($telat * -1) * $rental->car->denda;
            }

        } else {
            // cek apakah denda :
            if ($hariIni->diffInDays($tanggalAkhir, false) < 0) {

                $telat = $hariIni->diffInDays($tanggalAkhir, false);
                $denda = ($telat * -1) * $rental->car->denda;
            }

        }

        $selisihHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;

        return view('Customer.detail-rental', [
            'rental' => $rental->load('customer', 'vehicle'),
            'selisihHari' => $selisihHari,
            'totalHarga' => $selisihHari * $rental->vehicle->harga,
            'totalTelat' => $telat,
            'totalDenda' => $denda,
        ]);
    }
}

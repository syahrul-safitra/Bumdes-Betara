<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Kendaraan.index', [
            'vehicles' => Vehicle::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_plat' => 'required|string|max:10|unique:vehicles',
            'merek' => 'required|string|max:200', 
            'tahun' => 'required|string|max_digits:4',
            'warna' => 'required|string|max:50',
            'harga_perhari' => 'required|numeric|min:0',
            'denda_perhari' => 'required|numeric|min:0',
            'sewa_driver'    => 'required|numeric|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('gambar');
        $renameFile = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('File'), $renameFile);
        
        // Simpan nama file baru ke dalam array validated
        $validated['gambar'] = $renameFile;

        Vehicle::create($validated);

        return redirect('vehicle')->with('success', "Kendaraan berhasil di input");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view("Admin.Kendaraan.edit", [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            // Mengabaikan ID saat ini untuk validasi unique
            'no_plat' => 'required|string|max:10|unique:vehicles,no_plat,' . $vehicle->id,
            'merek' => 'required|string|max:200',
            'tahun' => 'required|string|max_digits:4',
            'warna' => 'required|string|max:50',
            'harga_perhari' => 'required|numeric|min:0',
            'denda_perhari' => 'required|numeric|min:0',
            'sewa_driver'    => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Diubah jadi nullable
        ]);

        // Jika ada file gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
        // Hapus gambar lama dari folder public/File jika ada
            $pathLama = public_path('File/'.$vehicle->gambar);
            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }

            // 2. Proses upload gambar baru
            $file = $request->file('gambar');
            $renameFile = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('File'), $renameFile);
            
            // Simpan nama file baru ke dalam array validated
            $validated['gambar'] = $renameFile;
        } else {
            // Jika tidak upload gambar baru, tetap gunakan gambar yang lama
            $validated['gambar'] = $vehicle->gambar;
        }

        // Update data ke database
        $vehicle->update($validated);

        return redirect('vehicle')->with('success', "Data kendaraan berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        File::delete('File/' . $vehicle->gambar);

        $vehicle->delete();

        return back()->with('success', "Data kendaraan berhasil dihapus");
    }
}

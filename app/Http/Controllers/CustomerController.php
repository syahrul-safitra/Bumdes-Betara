<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email', // pastikan tabel & kolom sesuai
            'no_telepon'    => 'required|string|max:15|unique:customers',
            'alamat'        => 'required|string',
            'password'      => 'required|string|min:8',
            'gambar_ktp'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Custom Pesan Error (Opsional agar lebih user-friendly)
            'email.unique'        => 'Email sudah terdaftar, silakan gunakan email lain.',
            'gambar_ktp.required' => 'Foto KTP wajib diunggah untuk verifikasi.',
            'gambar_ktp.max'      => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        // 2. Proses Upload Foto KTP
        if ($request->hasFile('gambar_ktp')) {
            $file = $request->file('gambar_ktp');
            
            // Penamaan file: KTP-Timestamp-Nama.ext
            $namaFileKtp = 'KTP-' . time() . '-' . $file->getClientOriginalExtension();
            
            // Simpan ke folder public/KTP
            $file->move(public_path('File'), $namaFileKtp);
            
            // Masukkan nama file ke array validated
            $validated['gambar_ktp'] = $namaFileKtp;
        }

        // 3. Enkripsi Password
        $validated['password'] = bcrypt($validated['password']);

        // 4. Simpan ke Database
        // Jika Anda menggunakan model User untuk customer, pastikan fillable-nya lengkap
        Customer::create($validated);

        // 5. Redirect dengan feedback
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login untuk mulai menyewa armada Buberta Rent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

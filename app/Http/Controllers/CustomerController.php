<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {$search = $request->input('search');

        $customers = Customer::when($search, function ($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('no_telepon', 'like', '%' . $search . '%');
            });
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
        return view('Admin.Customer.index', [
            'customers' => $customers,
        ]);
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
            'nama' => 'required|string|max:255',
            'tipe' => 'required',
            'email' => 'required|email|unique:customers,email|min:15|unique:admin',
            'no_telepon' => 'required|string|max:15|unique:customers',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|max:20',
            'file_identitas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Custom Pesan Error (Opsional agar lebih user-friendly)
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'file_identitas.required' => 'Foto KTP wajib diunggah untuk verifikasi.',
            'file_identitas.max' => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        if ($request->hasFile('file_identitas')) {
            $file = $request->file('file_identitas');

            // Penamaan file: KTP-Timestamp-Nama.ext
            $namaFileKtp = 'Identitas-'.time().'-'.$file->getClientOriginalName();

            // Simpan ke folder public/KTP
            $file->move(public_path('File'), $namaFileKtp);

            // Masukkan nama file ke array validated
            $validated['file_identitas'] = $namaFileKtp;
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
        return view('Admin.Customer.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {

        $validated = $request->validate([
            'nama' => 'required|string',
            'email' => [
                'required',
                'email',
                'min:15',
                'unique:customers,email,' . $customer->id,
                'unique:admin,email',
            ],
            'no_telepon' => 'required',
            'alamat' => 'required',
            'tipe' => 'required',
            'file_identitas' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'password' => 'nullable|min:8|max:20', // Password bersifat opsional
        ]);

        // Handle Password
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']); // Hapus dari array agar tidak mengubah password lama menjadi null
        }

        // Handle Upload Gambar
        if ($request->hasFile('file_identitas')) {
            // Hapus foto lama jika ingin menghemat storage
            // Storage::delete($customer->gambar_ktp);

            // File::delete('File/'.$customer->gambar_ktp);

            $file = $request->file('file_identitas');

            // Penamaan file: KTP-Timestamp-Nama.ext
            $namaFileKtp = 'Identitas-'.time().'-'.$file->getClientOriginalName();

            // Simpan ke folder public/KTP
            $file->move(public_path('File'), $namaFileKtp);

            // Masukkan nama file ke array validated
            $validated['file_identitas'] = $namaFileKtp;
        }

        $customer->update($validated);

        return redirect('/customer')->with('success', 'Data customer berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        File::delete('File/'.$customer->gambar_ktp);

        $customer->delete();

        return back()->with('success', 'Data Customer berhasil dihapus!');
    }
}

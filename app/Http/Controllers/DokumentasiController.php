<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Berita.index', [
            'dokumentasis' => Dokumentasi::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // 1. Validasi Data
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kontent' => 'required', // Data dari Trix Editor
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Menangani Upload Gambar dengan fungsi move()
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // Membuat nama file unik: timestamp-nama-asli.ekstensi
            $namaFile = time().'-'.$file->getClientOriginalName();

            // Pindahkan file ke direktori public/File
            $file->move(public_path('File'), $namaFile);
        }

        // 3. Simpan Data ke Database
        Dokumentasi::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'kontent' => $request->kontent,
            'gambar' => $namaFile, // Menyimpan nama filenya saja
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect('dokumentasi')
            ->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumentasi $dokumentasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        return view('Admin.Berita.edit', [
            'berita' => $dokumentasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {

        // 1. Validasi Data
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kontent' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Diubah jadi nullable
        ]);

        // Ambil nama gambar lama sebagai default
        $namaFile = $dokumentasi->gambar;

        // 2. Menangani Upload Gambar Baru (Jika Ada)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari folder public/File jika ada
            $pathLama = public_path('File/'.$dokumentasi->gambar);
            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }

            // Proses upload gambar baru
            $file = $request->file('gambar');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('File'), $namaFile);
        }

        // 3. Update Data ke Database
        $dokumentasi->update([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'kontent' => $request->kontent,
            'gambar' => $namaFile,
        ]);

        // 4. Redirect dengan alert success DaisyUI
        return redirect('dokumentasi')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        $namaFile = $dokumentasi->gambar;

        File::delete('File/'.$namaFile);

        $dokumentasi->delete();

        return back()->with('success', 'Berhasil menghapus data dokumentasi');
    }
}

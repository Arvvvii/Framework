<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\KategoriKlinis; // Hapus atau jadikan komentar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import Facade DB

class KategoriKlinisController extends Controller
{
    /**
     * Display a listing of the resource. (READ)
     */
    public function index()
    {
        // GANTI: $kategorikliniss = KategoriKlinis::all();
        // Menggunakan Query Builder
        $kategorikliniss = DB::table('kategori_klinis')->get();
        
        return view('admin.KategoriKlinis.index', compact('kategorikliniss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.KategoriKlinis.create');
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateKategoriKlinis($request);

        // GANTI: Menggunakan helper createKategoriKlinis yang sudah diubah
        $this->createKategoriKlinis($validated);

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'Kategori klinis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     * CATATAN: Model Binding diganti dengan ID ($idkategori_klinis)
     */
    public function show($idkategori_klinis)
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $kategoriklinis = DB::table('kategori_klinis')->where('idkategori_klinis', $idkategori_klinis)->first();

        if (!$kategoriklinis) {
            abort(404);
        }
        
        return view('admin.KategoriKlinis.show', compact('kategoriklinis'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     * CATATAN: Model Binding diganti dengan ID ($idkategori_klinis)
     */
    public function edit($idkategori_klinis)
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $kategoriklinis = DB::table('kategori_klinis')->where('idkategori_klinis', $idkategori_klinis)->first();

        if (!$kategoriklinis) {
            abort(404);
        }

        return view('admin.KategoriKlinis.edit', compact('kategoriklinis'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idkategori_klinis) // Model Binding diganti
    {
        $validated = $this->validateKategoriKlinis($request, $idkategori_klinis);

        // GANTI: Menggunakan Query Builder untuk update
        // Only update columns that actually exist on the table (no timestamps)
        DB::table('kategori_klinis')
            ->where('idkategori_klinis', $idkategori_klinis)
            ->update([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($validated['nama_kategori_klinis']),
            ]);

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'Kategori klinis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idkategori_klinis) // Model Binding diganti
    {
        // GANTI: Menggunakan Query Builder untuk delete
        DB::table('kategori_klinis')
            ->where('idkategori_klinis', $idkategori_klinis)
            ->delete();

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'KategoriKlinis deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA KARENA LOGIC VALIDASI TIDAK BERUBAH) ---

    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis'
            : 'unique:kategori_klinis,nama_kategori_klinis';

        return $request->validate([
            'nama_kategori_klinis' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string' => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.min' => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 255 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah terdaftar.',
        ]);
    }

    /**
     * Create helper for Kategori Klinis
     */
    protected function createKategoriKlinis(array $data)
    {
        // GANTI: Menggunakan Query Builder untuk INSERT
        // Insert only the columns that exist. The table does not include timestamps.
        return DB::table('kategori_klinis')->insert([
            'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis']),
        ]);
    }

    /**
     * Format helper for Kategori Klinis
     */
    protected function formatNamaKategoriKlinis(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
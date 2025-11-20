<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Kategori; // Hapus atau jadikan komentar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import Facade DB

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource. (READ)
     */
    public function index()
    {
        // GANTI: $kategoris = Kategori::all();
        // Menggunakan Query Builder
        $kategoris = DB::table('kategori')->get();
        
        // Output adalah stdClass Object, yang cocok dibaca oleh View Blade
        return view('admin.Kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Kategori.create');
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateKategori($request);

        // GANTI: Menggunakan helper createKategori yang sudah diubah
        $this->createKategori($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     * CATATAN: Model Binding diganti dengan ID ($idkategori)
     */
    public function show($idkategori)
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $kategori = DB::table('kategori')->where('idkategori', $idkategori)->first();
                        
        if (!$kategori) {
            abort(404);
        }
        
        return view('admin.Kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     * CATATAN: Model Binding diganti dengan ID ($idkategori)
     */
    public function edit($idkategori)
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $kategori = DB::table('kategori')->where('idkategori', $idkategori)->first();

        if (!$kategori) {
            abort(404);
        }
        
        return view('admin.Kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idkategori) // Model Binding diganti
    {
        $validated = $this->validateKategori($request, $idkategori);

        // GANTI: Menggunakan Query Builder untuk update
        DB::table('kategori')
            ->where('idkategori', $idkategori)
            ->update([
                'nama_kategori' => $this->formatNamaKategori($validated['nama_kategori']),
                'updated_at' => now(), // Tambahkan manual jika kolom ada
            ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idkategori) // Model Binding diganti
    {
        // GANTI: Menggunakan Query Builder untuk delete
        DB::table('kategori')
            ->where('idkategori', $idkategori)
            ->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA KARENA LOGIC VALIDASI TIDAK BERUBAH) ---

    protected function validateKategori(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kategori,nama_kategori,' . $id . ',idkategori'
            : 'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah terdaftar.',
        ]);
    }

    /**
     * Create helper for Kategori
     */
    protected function createKategori(array $data)
    {
        // GANTI: Menggunakan Query Builder untuk INSERT
        return DB::table('kategori')->insert([
            'nama_kategori' => $this->formatNamaKategori($data['nama_kategori']),
            'created_at' => now(), // Tambahkan manual jika kolom ada
            'updated_at' => now(), // Tambahkan manual jika kolom ada
        ]);
    }

    /**
     * Format helper for Kategori
     */
    protected function formatNamaKategori(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
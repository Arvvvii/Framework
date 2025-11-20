<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import Facade DB untuk Query Builder
// use App\Models\JenisHewan; // Hapus atau jadikan komentar karena kita tidak lagi menggunakan Model ini secara langsung

class JenisHewanController extends Controller
{
    /**
     * Display a listing of the resource. (READ)
     */
    public function index()
    {
        // GANTI: $jenishawans = JenisHewan::all();
        // Menggunakan Query Builder
        $jenishawans = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->get();
            
        // Output Query Builder adalah stdClass Object, yang cocok dibaca oleh View Blade
        return view('admin.JenisHewan.index', compact('jenishawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.JenisHewan.create');
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        // Validasi masih menggunakan helper validateJenisHewan
        $validated = $this->validateJenisHewan($request);

        // GANTI: Menggunakan helper createJenisHewan yang sudah diubah ke Query Builder
        $this->createJenisHewan($validated);

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     * CATATAN: Ini membutuhkan perbaikan karena tidak bisa menggunakan Model Binding (JenisHewan $jenishawan)
     */
    public function show($idjenis_hewan) // Parameter diubah menjadi ID
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $jenishawan = DB::table('jenis_hewan')
                        ->where('idjenis_hewan', $idjenis_hewan)
                        ->first();
                        
        if (!$jenishawan) {
            abort(404);
        }
        
        // CATATAN: Variabel dikembalikan sebagai $jenishawan agar kompatibel dengan View
        return view('admin.JenisHewan.show', compact('jenishawan'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     * CATATAN: Ini membutuhkan perbaikan karena tidak bisa menggunakan Model Binding
     */
    public function edit($idjenis_hewan) // Parameter diubah menjadi ID
    {
        // Menggunakan Query Builder untuk ambil 1 data
        $jenishawan = DB::table('jenis_hewan')
                        ->where('idjenis_hewan', $idjenis_hewan)
                        ->first();

        if (!$jenishawan) {
            abort(404);
        }
        
        return view('admin.JenisHewan.edit', compact('jenishawan'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idjenis_hewan) // Parameter diubah menjadi ID
    {
        // Validasi masih menggunakan helper validateJenisHewan
        $validated = $this->validateJenisHewan($request, $idjenis_hewan);

        // GANTI: Menggunakan Query Builder untuk update
        DB::table('jenis_hewan')
            ->where('idjenis_hewan', $idjenis_hewan)
            ->update([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($validated['nama_jenis_hewan']),
                // updated_at akan diurus Query Builder secara otomatis jika kolomnya ada
            ]);

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idjenis_hewan) // Parameter diubah menjadi ID
    {
        // GANTI: Menggunakan Query Builder untuk delete
        DB::table('jenis_hewan')
            ->where('idjenis_hewan', $idjenis_hewan)
            ->delete();

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil dihapus.');
    }

    // --- HELPER METHOD (TETAP SAMA, TAPI DISESUAIKAN DENGAN DB::table()) ---

    /**
     * Validate input for create/update
     * Note: Karena kita masih menggunakan Request->validate, logic ini masih bekerja dengan baik
     */
    protected function validateJenisHewan(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan'
            : 'unique:jenis_hewan,nama_jenis_hewan';

        return $request->validate([
            'nama_jenis_hewan' => ['required', 'string', 'max:255', 'min:3', $uniqueRule],
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.min' => 'Nama jenis hewan minimal 3 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah terdaftar.',
        ]);
    }

    /**
     * Helper to create jenis hewan record
     */
    protected function createJenisHewan(array $data)
    {
        // GANTI: Menggunakan Query Builder untuk INSERT
        // Note: Query Builder::insert() mengembalikan boolean (true/false)
        return DB::table('jenis_hewan')->insert([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            'created_at' => now(), // Tambahkan manual jika kolom ada
            'updated_at' => now(), // Tambahkan manual jika kolom ada
        ]);
    }

    /**
     * Format nama jenis hewan (title case)
     */
    protected function formatNamaJenisHewan(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
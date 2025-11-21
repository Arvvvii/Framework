<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\KodeTindakanTerapi; // Hapus atau jadikan komentar
use App\Models\Kategori; // Tetap diperlukan untuk create/edit form
use App\Models\KategoriKlinis; // Tetap diperlukan untuk create/edit form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class KodeTindakanTerapiController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get();
        // Menggunakan Query Builder dengan JOIN (Left Join diasumsikan jika relasi tidak wajib)
        $kodeterapis = DB::table('kode_tindakan_terapi AS ktt')
            ->leftJoin('kategori AS kat', 'ktt.idkategori', '=', 'kat.idkategori')
            ->leftJoin('kategori_klinis AS kk', 'ktt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->select(
                'ktt.*', // Ambil semua kolom dari kode_tindakan_terapi
                'kat.nama_kategori', // Ambil nama kategori
                'kk.nama_kategori_klinis' // Ambil nama kategori klinis
            )
            ->get();
            
        return view('admin.KodeTindakanTerapi.index', compact('kodeterapis'));
    }

    /**
     * Show the form for creating a new resource. (Helper data tetap Eloquent)
     */
    public function create()
    {
        // Panggilan helper data (Kategori, KategoriKlinis) tetap menggunakan Eloquent untuk kemudahan
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.create', compact('kategoris', 'kategorikliniss'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateKodeTindakanTerapi($request);

        $this->createKodeTindakanTerapi($validated);

        return redirect()->route('admin.kodeterapi.index')->with('success', 'Kode terapi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idkode_tindakan_terapi) // Model Binding diganti
    {
        // Query Builder untuk ambil 1 data utama
        $kodeterapi = DB::table('kode_tindakan_terapi')
                        ->where('idkode_tindakan_terapi', $idkode_tindakan_terapi)
                        ->first();
                        
        if (!$kodeterapi) {
            abort(404);
        }

        // CATATAN: Untuk relasi di show, Anda harus menggunakan Query Builder lagi jika View membutuhkannya.
        // Jika View hanya menampilkan data dari tabel utama (ktt), ini sudah cukup.
        return view('admin.KodeTindakanTerapi.show', compact('kodeterapi'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idkode_tindakan_terapi) // Model Binding diganti
    {
        $kodeterapi = DB::table('kode_tindakan_terapi')
                        ->where('idkode_tindakan_terapi', $idkode_tindakan_terapi)
                        ->first();
                        
        if (!$kodeterapi) {
            abort(404);
        }
                        
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.edit', compact('kodeterapi', 'kategoris', 'kategorikliniss'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idkode_tindakan_terapi) // Model Binding diganti
    {
        $validated = $this->validateKodeTindakanTerapi($request, $idkode_tindakan_terapi);

        // GANTI: Menggunakan Query Builder untuk update
        DB::table('kode_tindakan_terapi')
            ->where('idkode_tindakan_terapi', $idkode_tindakan_terapi)
            ->update([
                'kode' => $validated['kode'],
                'deskripsi_tindakan_terapi' => $validated['deskripsi_tindakan_terapi'],
                'idkategori' => $validated['idkategori'],
                'idkategori_klinis' => $validated['idkategori_klinis'],
            ]);

        return redirect()->route('admin.kodeterapi.index')->with('success', 'Kode terapi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idkode_tindakan_terapi) // Model Binding diganti
    {
        // GANTI: Menggunakan Query Builder untuk delete
        DB::table('kode_tindakan_terapi')
            ->where('idkode_tindakan_terapi', $idkode_tindakan_terapi)
            ->delete();

        return redirect()->route('admin.kodeterapi.index')->with('success', 'KodeTindakanTerapi deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA KARENA LOGIC VALIDASI TIDAK BERUBAH) ---

    protected function validateKodeTindakanTerapi(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi'
            : 'unique:kode_tindakan_terapi,kode';

        return $request->validate([
            'kode' => ['required', 'string', 'min:1', 'max:255', $uniqueRule],
            'deskripsi_tindakan_terapi' => ['required', 'string', 'max:255'],
            'idkategori' => ['required', 'exists:kategori,idkategori'],
            'idkategori_klinis' => ['required', 'exists:kategori_klinis,idkategori_klinis'],
        ], [
            'kode.required' => 'Kode terapi wajib diisi.',
            'kode.string' => 'Kode terapi harus berupa teks.',
            'kode.max' => 'Kode terapi maksimal 255 karakter.',
            'kode.unique' => 'Kode terapi sudah terdaftar.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori.exists' => 'Kategori tidak ditemukan.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
            'idkategori_klinis.exists' => 'Kategori klinis tidak ditemukan.',
        ]);
    }

    /**
     * Create helper for Kode Tindakan Terapi
     */
    protected function createKodeTindakanTerapi(array $data)
    {
        // GANTI: Menggunakan Query Builder untuk INSERT
        return DB::table('kode_tindakan_terapi')->insert([
            'kode' => $data['kode'],
            'deskripsi_tindakan_terapi' => $data['deskripsi_tindakan_terapi'],
            'idkategori' => $data['idkategori'],
            'idkategori_klinis' => $data['idkategori_klinis'],
        ]);
    }
}
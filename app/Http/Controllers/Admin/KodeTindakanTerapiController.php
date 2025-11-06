<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KodeTindakanTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeterapis = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get();
        return view('admin.KodeTindakanTerapi.index', compact('kodeterapis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.create', compact('kategoris', 'kategorikliniss'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateKodeTindakanTerapi($request);

        $this->createKodeTindakanTerapi($validated);

        return redirect()->route('admin.kodeterapi.index')->with('success', 'Kode terapi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeTindakanTerapi $kodeterapi)
    {
        $kodeterapi->load('kategori', 'kategoriKlinis');
        return view('admin.KodeTindakanTerapi.show', compact('kodeterapi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KodeTindakanTerapi $kodeterapi)
    {
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.edit', compact('kodeterapi', 'kategoris', 'kategorikliniss'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KodeTindakanTerapi $kodeterapi)
    {
        $validated = $this->validateKodeTindakanTerapi($request, $kodeterapi->idkode_tindakan_terapi);

        $kodeterapi->update([
            'kode' => $validated['kode'],
            'deskripsi_tindakan_terapi' => $validated['deskripsi_tindakan_terapi'],
            'idkategori' => $validated['idkategori'],
            'idkategori_klinis' => $validated['idkategori_klinis'],
        ]);

        return redirect()->route('admin.kodeterapi.index')->with('success', 'Kode terapi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KodeTindakanTerapi $kodeterapi)
    {
        $kodeterapi->delete();

        return redirect()->route('admin.kodeterapi.index')->with('success', 'KodeTindakanTerapi deleted successfully.');
    }

    /**
     * Validation helper for Kode Tindakan Terapi
     */
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
        return KodeTindakanTerapi::create([
            'kode' => $data['kode'],
            'deskripsi_tindakan_terapi' => $data['deskripsi_tindakan_terapi'],
            'idkategori' => $data['idkategori'],
            'idkategori_klinis' => $data['idkategori_klinis'],
        ]);
    }
}

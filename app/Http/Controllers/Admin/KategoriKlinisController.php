<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriKlinisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategorikliniss = KategoriKlinis::all();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateKategoriKlinis($request);

        $this->createKategoriKlinis($validated);

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'Kategori klinis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriKlinis $kategoriklinis)
    {
        return view('admin.KategoriKlinis.show', compact('kategoriklinis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriKlinis $kategoriklinis)
    {
        return view('admin.KategoriKlinis.edit', compact('kategoriklinis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriKlinis $kategoriklinis)
    {
        $validated = $this->validateKategoriKlinis($request, $kategoriklinis->idkategori_klinis);

        $kategoriklinis->update([
            'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($validated['nama_kategori_klinis']),
        ]);

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'Kategori klinis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriKlinis $kategoriklinis)
    {
        $kategoriklinis->delete();

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'KategoriKlinis deleted successfully.');
    }

    /**
     * Validation helper for Kategori Klinis
     */
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
        return KategoriKlinis::create([
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenishawans = JenisHewan::all();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input and create using helper methods
        $validated = $this->validateJenisHewan($request);

        $jenis = $this->createJenisHewan($validated);

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisHewan $jenishawan)
    {
        return view('admin.JenisHewan.show', compact('jenishawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisHewan $jenishawan)
    {
        return view('admin.JenisHewan.edit', compact('jenishawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisHewan $jenishawan)
    {
        $validated = $this->validateJenisHewan($request, $jenishawan->idjenis_hewan);

        $jenishawan->update([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($validated['nama_jenis_hewan']),
        ]);

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisHewan $jenishawan)
    {
        $jenishawan->delete();

        return redirect()->route('admin.jenishewan.index')->with('success', 'Jenis hewan berhasil dihapus.');
    }

    /**
     * Validate input for create/update
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
        return JenisHewan::create([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
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

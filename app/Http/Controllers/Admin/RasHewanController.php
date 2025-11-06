<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RasHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rashewans = RasHewan::with('jenisHewan')->get();
        return view('admin.RasHewan.index', compact('rashewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenishawans = JenisHewan::all();
        return view('admin.RasHewan.create', compact('jenishawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRasHewan($request);

        $this->createRasHewan($validated);

        return redirect()->route('admin.rashewan.index')->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RasHewan $rashewan)
    {
        $rashewan->load('jenisHewan');
        return view('admin.RasHewan.show', compact('rashewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RasHewan $rashewan)
    {
        $jenishawans = JenisHewan::all();
        return view('admin.RasHewan.edit', compact('rashewan', 'jenishawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RasHewan $rashewan)
    {
        $validated = $this->validateRasHewan($request, $rashewan->idras_hewan);

        $rashewan->update([
            'nama_ras' => $this->formatNamaRas($validated['nama_ras']),
            'idjenis_hewan' => $validated['idjenis_hewan'],
        ]);

        return redirect()->route('admin.rashewan.index')->with('success', 'Ras hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RasHewan $rashewan)
    {
        $rashewan->delete();

        return redirect()->route('admin.rashewan.index')->with('success', 'RasHewan deleted successfully.');
    }

    /**
     * Validation helper for RasHewan
     */
    protected function validateRasHewan(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan'
            : 'unique:ras_hewan,nama_ras';

        return $request->validate([
            'nama_ras' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
            'idjenis_hewan' => ['required', 'exists:jenis_hewan,idjenis_hewan'],
        ], [
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'nama_ras.string' => 'Nama ras harus berupa teks.',
            'nama_ras.min' => 'Nama ras minimal 3 karakter.',
            'nama_ras.max' => 'Nama ras maksimal 255 karakter.',
            'nama_ras.unique' => 'Nama ras sudah terdaftar.',
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak ditemukan.',
        ]);
    }

    /**
     * Create helper for RasHewan
     */
    protected function createRasHewan(array $data)
    {
        return RasHewan::create([
            'nama_ras' => $this->formatNamaRas($data['nama_ras']),
            'idjenis_hewan' => $data['idjenis_hewan'],
        ]);
    }

    /**
     * Format helper for Nama Ras
     */
    protected function formatNamaRas(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}

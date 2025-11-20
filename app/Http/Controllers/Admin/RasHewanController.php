<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\RasHewan; // Hapus atau jadikan komentar
use App\Models\JenisHewan; // Tetap diperlukan untuk create/edit form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class RasHewanController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: $rashewans = RasHewan::with('jenisHewan')->get();
        // Menggunakan Query Builder dengan JOIN
        $rashewans = DB::table('ras_hewan AS rh')
            ->leftJoin('jenis_hewan AS jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select('rh.*', 'jh.nama_jenis_hewan') // Tambahkan kolom relasi yang dibutuhkan
            ->get();
            
        return view('admin.RasHewan.index', compact('rashewans'));
    }

    /**
     * Show the form for creating a new resource. (Helper data tetap Eloquent)
     */
    public function create()
    {
        $jenishawans = JenisHewan::all(); // Tetap pakai Eloquent untuk helper data
        return view('admin.RasHewan.create', compact('jenishawans'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateRasHewan($request);

        $this->createRasHewan($validated);

        return redirect()->route('admin.rashewan.index')->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idras_hewan) // Model Binding diganti
    {
        $rashewan = DB::table('ras_hewan')->where('idras_hewan', $idras_hewan)->first();
        if (!$rashewan) {
            abort(404);
        }
        return view('admin.RasHewan.show', compact('rashewan'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idras_hewan) // Model Binding diganti
    {
        $rashewan = DB::table('ras_hewan')->where('idras_hewan', $idras_hewan)->first();
        if (!$rashewan) {
            abort(404);
        }
        
        $jenishawans = JenisHewan::all();
        return view('admin.RasHewan.edit', compact('rashewan', 'jenishawans'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idras_hewan) // Model Binding diganti
    {
        $validated = $this->validateRasHewan($request, $idras_hewan);

        // GANTI: $rashewan->update([...]);
        DB::table('ras_hewan')
            ->where('idras_hewan', $idras_hewan)
            ->update([
                'nama_ras' => $this->formatNamaRas($validated['nama_ras']),
                'idjenis_hewan' => $validated['idjenis_hewan'],
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.rashewan.index')->with('success', 'Ras hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idras_hewan) // Model Binding diganti
    {
        // GANTI: $rashewan->delete();
        DB::table('ras_hewan')->where('idras_hewan', $idras_hewan)->delete();

        return redirect()->route('admin.rashewan.index')->with('success', 'RasHewan deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA) ---

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
        // GANTI: Menggunakan Query Builder untuk INSERT
        return DB::table('ras_hewan')->insert([
            'nama_ras' => $this->formatNamaRas($data['nama_ras']),
            'idjenis_hewan' => $data['idjenis_hewan'],
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
    }

    protected function formatNamaRas(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
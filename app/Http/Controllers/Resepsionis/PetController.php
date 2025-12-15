<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        return view('resepsionis.Pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::whereNull('deleted_at')->get();
        return view('resepsionis.Pet.create', compact('pemilik', 'rasHewan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:M,F',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'required|string',
            'id_pemilik' => 'required|exists:pemilik,idpemilik',
            'id_ras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        Pet::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'idpemilik' => $request->id_pemilik,
            'idras_hewan' => $request->id_ras_hewan,
        ]);

        return redirect()->route('resepsionis.pet.index')->with('success', 'Pet berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::whereNull('deleted_at')->get();
        return view('resepsionis.Pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:M,F',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'required|string',
            'id_pemilik' => 'required|exists:pemilik,idpemilik',
            'id_ras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        $pet = Pet::findOrFail($id);
        $pet->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'idpemilik' => $request->id_pemilik,
            'idras_hewan' => $request->id_ras_hewan,
        ]);

        return redirect()->route('resepsionis.pet.index')->with('success', 'Pet berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pet = Pet::findOrFail($id);

            // use is_deleted flag soft-delete; cascade handled below
            // delete related temu_dokter and rekam_medis first
            $temu = $pet->temuDokter()->get();
            foreach ($temu as $t) {
                // mark related rekam_medis as deleted
                foreach ($t->rekamMedis()->get() as $rm) {
                    $rm->markDeleted();
                }
                $t->markDeleted();
            }

            $pet->markDeleted();

            DB::commit();
            return redirect()->route('resepsionis.pet.index')->with('success', 'Pet berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pet: ' . $e->getMessage());
        }
    }
}

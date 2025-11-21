<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use Illuminate\Http\Request;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temuDokter = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan', 'rekamMedis')
            ->orderBy('waktu_daftar', 'desc')
            ->get();
        return view('admin.TemuDokter.index', compact('temuDokter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        return view('admin.TemuDokter.create', compact('pets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            // keluhan is optional because the database may not contain the column
            'keluhan' => 'nullable|string',
        ]);

        // Try to determine the current user's `role_user` record so we can
        // populate the required `idrole_user` column. In typical setups the
        // authenticated admin will have an associated `role_user` record.
        $roleUser = auth()->user() ? auth()->user()->roleUsers()->first() : null;

        TemuDokter::create([
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $roleUser->idrole_user ?? null,
            // intentionally not persisting 'keluhan' to avoid SQL error when
            // the `temu_dokter` table lacks that column
        ]);

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        return view('admin.TemuDokter.edit', compact('temuDokter', 'pets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            'keluhan' => 'nullable|string',
        ]);

        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->update([
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            // not updating 'keluhan' to avoid writing to a non-existent column
        ]);

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->delete();

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil dihapus!');
    }
}

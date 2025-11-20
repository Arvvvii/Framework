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
        $temuDokter = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan')
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
            'keluhan' => 'required|string',
        ]);

        TemuDokter::create([
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            'keluhan' => $request->keluhan,
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
            'keluhan' => 'required|string',
        ]);

        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->update([
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            'keluhan' => $request->keluhan,
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

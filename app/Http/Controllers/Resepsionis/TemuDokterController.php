<?php

namespace App\Http\Controllers\Resepsionis;

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
        return view('resepsionis.TemuDokter.index', compact('temuDokter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        return view('resepsionis.TemuDokter.create', compact('pets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            'keluhan' => 'required|string', // kept for UX but not stored (no keluhan column in DB)
        ]);

        // Determine current user's role_user id to store as idrole_user
        $roleUser = auth()->user()->roleUsers()->first();

        TemuDokter::create([
            'idpet' => $request->id_pet,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $roleUser->idrole_user ?? null,
            'status' => '1', // default to '1' (Menunggu)
        ]);

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibuat!');
    }

    /**
     * Cancel (delete) the specified resource.
     */
    public function destroy($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->delete();

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibatalkan!');
    }
}

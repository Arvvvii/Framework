<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DataUser;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.Dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unassignedUsers = DataUser::whereDoesntHave('dokter')->get();
        return view('admin.Dokter.create', compact('unassignedUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|unique:dokter,id_user',
            'alamat' => 'required',
            'no_hp' => 'required',
            'bidang_dokter' => 'required',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.Dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $unassignedUsers = DataUser::whereDoesntHave('dokter')
            ->orWhere('iduser', $dokter->id_user)
            ->get();
        return view('admin.Dokter.edit', compact('dokter', 'unassignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'id_user' => 'required|unique:dokter,id_user,' . $id . ',id_dokter',
            'alamat' => 'required',
            'no_hp' => 'required',
            'bidang_dokter' => 'required',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perawat;
use App\Models\DataUser;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perawats = Perawat::with('user')->get();
        return view('admin.Perawat.index', compact('perawats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unassignedUsers = DataUser::whereDoesntHave('perawat')->get();
        return view('admin.Perawat.create', compact('unassignedUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|unique:perawat,id_user',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan' => 'required'
        ]);

        Perawat::create($request->all());

        return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $perawat = Perawat::with('user')->findOrFail($id);
        return view('admin.Perawat.show', compact('perawat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $perawat = Perawat::findOrFail($id);
        $unassignedUsers = DataUser::whereDoesntHave('perawat')
            ->orWhere('iduser', $perawat->id_user)
            ->get();
        return view('admin.Perawat.edit', compact('perawat', 'unassignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $perawat = Perawat::findOrFail($id);

        $request->validate([
            'id_user' => 'required|unique:perawat,id_user,' . $id . ',id_perawat',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan' => 'required'
        ]);

        $perawat->update($request->all());

        return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perawat = Perawat::findOrFail($id);
        $perawat->delete();

        return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil dihapus');
    }
}

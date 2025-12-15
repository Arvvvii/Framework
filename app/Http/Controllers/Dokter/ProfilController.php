<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Dokter model stores the foreign key as `id_user` referencing `datauser.iduser`
        $dokter = Dokter::with('user')->where('id_user', $user->iduser)->first();
        return view('dokter.Profil.index', compact('dokter'));
    }

    public function edit()
    {
        $user = Auth::user();
        $dokter = Dokter::with('user')->where('id_user', $user->iduser)->firstOrFail();
        return view('dokter.Profil.edit', compact('dokter'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $dokter = Dokter::with('user')->where('id_user', $user->iduser)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->iduser . ',iduser',
            'no_hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'bidang_dokter' => 'nullable|string|max:255',
        ]);

        // update user
        $dokter->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        // update dokter profile
        $dokter->update($request->only('no_hp', 'alamat', 'bidang_dokter'));

        return redirect()->route('dokter.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}

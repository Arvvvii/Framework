<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Perawat;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perawat = Perawat::with('user')->where('id_user', $user->iduser)->first();
        return view('perawat.Profil.index', compact('perawat'));
    }

    public function edit()
    {
        $user = Auth::user();
        $perawat = Perawat::with('user')->where('id_user', $user->iduser)->firstOrFail();
        return view('perawat.Profil.edit', compact('perawat'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $perawat = Perawat::with('user')->where('id_user', $user->iduser)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->iduser . ',iduser',
            'no_hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:255',
        ]);

        $perawat->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $perawat->update($request->only('no_hp', 'alamat', 'pendidikan'));

        return redirect()->route('perawat.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}

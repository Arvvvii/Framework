<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemilik;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pemilik = Pemilik::with('user')->where('iduser', $user->iduser)->first();
        return view('pemilik.Profil.index', compact('pemilik'));
    }

    public function edit()
    {
        $user = Auth::user();
        $pemilik = Pemilik::with('user')->where('iduser', $user->iduser)->firstOrFail();
        return view('pemilik.Profil.edit', compact('pemilik'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $pemilik = Pemilik::with('user')->where('iduser', $user->iduser)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->iduser . ',iduser',
            'no_wa' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $pemilik->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $pemilik->update($request->only('no_wa', 'alamat'));

        return redirect()->route('pemilik.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}

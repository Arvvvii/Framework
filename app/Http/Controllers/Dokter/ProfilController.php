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
}

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
}

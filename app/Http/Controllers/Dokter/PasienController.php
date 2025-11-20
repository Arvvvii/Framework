<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pet::with('pemilik.user')->get();

        // If this route is accessed under the perawat route group, render perawat view
        if (request()->routeIs('perawat.*')) {
            return view('perawat.Pasien.index', compact('pasiens'));
        }

        return view('dokter.Pasien.index', compact('pasiens'));
    }
}

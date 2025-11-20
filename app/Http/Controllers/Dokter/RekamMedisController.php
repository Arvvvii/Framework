<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pet)
    {
        $rekamMedis = \App\Models\RekamMedis::whereHas('temuDokter', function($q) use ($pet) {
            $q->where('idpet', $pet);
        })->with('temuDokter.pet.pemilik.user', 'temuDokter.pet.rasHewan', 'roleUser.user')->get();
        $petData = \App\Models\Pet::with('pemilik.user', 'rasHewan.jenisHewan')->findOrFail($pet);
        return view('dokter.RekamMedis.index', compact('rekamMedis', 'petData'));
    }
}

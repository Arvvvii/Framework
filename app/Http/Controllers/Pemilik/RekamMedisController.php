<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get current user
        $userId = session('user_id');
        
        // Get pemilik data
        $pemilik = Pemilik::where('iduser', $userId)->first();
        
        if (!$pemilik) {
            $rekamMedis = collect();
        } else {
            $rekamMedis = RekamMedis::with('temuDokter.pet', 'roleUser.user')
                ->whereHas('temuDokter.pet', function($query) use ($pemilik) {
                    $query->where('idpemilik', $pemilik->idpemilik);
                })
                ->orderBy('idrekam_medis', 'desc')
                ->get();
        }
        
        return view('pemilik.RekamMedis.index', compact('rekamMedis'));
    }

    /**
     * Tampilkan satu rekam medis milik pemilik yang sedang login.
     */
    public function show($rekamMedisId)
    {
        $userId = session('user_id');
        $pemilik = Pemilik::where('iduser', $userId)->firstOrFail();

        $rekamMedis = RekamMedis::with('temuDokter.pet.pemilik.user', 'detailRekamMedis.kodeTindakanTerapi', 'roleUser.user')
            ->whereHas('temuDokter.pet', function($q) use ($pemilik){
                $q->where('idpemilik', $pemilik->idpemilik);
            })
            ->findOrFail($rekamMedisId);

        return view('pemilik.RekamMedis.show', compact('rekamMedis'));
    }
}

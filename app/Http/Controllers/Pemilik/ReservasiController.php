<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class ReservasiController extends Controller
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
            $reservasi = collect();
        } else {
            $reservasi = TemuDokter::with(['pet.rasHewan', 'rekamMedis'])
                ->whereHas('pet', function($query) use ($pemilik) {
                    $query->where('idpemilik', $pemilik->idpemilik);
                })
                ->orderBy('waktu_daftar', 'desc')
                ->get();
        }
        
        return view('pemilik.Reservasi.index', compact('reservasi'));
    }
}

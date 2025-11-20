<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class PetController extends Controller
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
            $pets = collect();
        } else {
            $pets = Pet::with('pemilik.user', 'rasHewan')
                ->where('idpemilik', $pemilik->idpemilik)
                ->get();
        }
        
        return view('pemilik.Pet.index', compact('pets', 'pemilik'));
    }
}

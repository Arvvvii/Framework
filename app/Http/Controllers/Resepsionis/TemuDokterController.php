<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use Illuminate\Http\Request;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temuDokter = TemuDokter::with('pet.pemilik', 'pet.rasHewan')->get();
        return view('resepsionis.TemuDokter.index', compact('temuDokter'));
    }
}

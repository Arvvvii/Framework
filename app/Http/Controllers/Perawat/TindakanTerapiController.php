<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;

class TindakanTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeTindakanTerapis = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get();
        return view('perawat.TindakanTerapi.index', compact('kodeTindakanTerapis'));
    }
}

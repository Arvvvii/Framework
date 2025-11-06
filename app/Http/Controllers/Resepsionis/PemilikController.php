<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager-load related DataUser to access name/email without N+1 queries
        $pemilik = Pemilik::with('user')->get();
        return view('resepsionis.Pemilik.index', compact('pemilik'));
    }
}

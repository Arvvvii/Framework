<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        return view('site.home');
    }

    /**
     * Display the struktur organisasi page.
     */
    public function strukturOrganisasi()
    {
        return view('site.strukturorganisasi');
    }

    /**
     * Display the layanan umum page.
     */
    public function layananUmum()
    {
        return view('site.layananumum');
    }

    /**
     * Display the visi misi tujuan page.
     */
    public function visiMisi()
    {
        return view('site.visimisi');
    }

    /**
     * Display the berita page.
     */
    public function berita()
    {
        return view('site.berita');
    }

    /**
     * Check database connection.
     */
    public function cekKoneksi()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['status' => 'success', 'message' => 'Database connection is successful']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
        }
    }
}

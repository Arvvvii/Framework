<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataUser;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use App\Models\JenisHewan;
use App\Models\RasHewan;
use App\Models\KodeTindakanTerapi;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'total_users' => DataUser::count(),
            'total_roles' => Role::count(),
            'total_pets' => Pet::count(),
            'total_pemilik' => Pemilik::count(),
            'total_kategori' => Kategori::count(),
            'total_kategori_klinis' => KategoriKlinis::count(),
            'total_jenis_hewan' => JenisHewan::count(),
            'total_ras_hewan' => RasHewan::count(),
            'total_kode_terapi' => KodeTindakanTerapi::count(),
        ];

        // Get recent activities (you can customize this based on your needs)
        $recent_users = DataUser::orderBy('iduser', 'desc')->take(5)->get();
        $recent_pets = Pet::with('pemilik')->orderBy('idpet', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_pets'));
    }
}

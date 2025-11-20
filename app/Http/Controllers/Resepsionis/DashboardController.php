<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataUser;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RekamMedis;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the resepsionis dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalPemilik = Pemilik::count();
        $totalPet = Pet::count();
        $totalTemuDokter = \App\Models\TemuDokter::count();

        return view('resepsionis.dashboard', compact('totalPemilik', 'totalPet', 'totalTemuDokter'));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStats()
    {
        $today = Carbon::today();

        return response()->json([
            'today_registrations' => RekamMedis::whereDate('created_at', $today)->count(),
            'total_patients' => Pet::count(),
            'total_owners' => Pemilik::count(),
            'pending_appointments' => 0, // Customize based on your system
        ]);
    }
}

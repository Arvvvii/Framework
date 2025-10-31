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
        // Get today's statistics
        $today = Carbon::today();

        $stats = [
            'today_registrations' => RekamMedis::whereDate('created_at', $today)->count(),
            'total_patients' => Pet::count(),
            'total_owners' => Pemilik::count(),
            'pending_appointments' => 0, // You can customize this based on your appointment system
        ];

        // Get today's registrations
        $today_registrations = RekamMedis::with(['pet.pemilik'])
            ->whereDate('created_at', $today)
            ->orderBy('idrekam_medis', 'desc')
            ->take(10)
            ->get();

        // Get upcoming appointments (placeholder - customize based on your system)
        $upcoming_appointments = []; // You can implement this based on your appointment model

        // Get recent patients
        $recent_patients = Pet::with('pemilik')
            ->orderBy('idpet', 'desc')
            ->take(5)
            ->get();

        return view('resepsionis.dashboard', compact(
            'stats',
            'today_registrations',
            'upcoming_appointments',
            'recent_patients'
        ));
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

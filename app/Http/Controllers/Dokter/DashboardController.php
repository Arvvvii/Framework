<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\RoleUser;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dokter dashboard.
     */
    public function index()
    {
        // Get today's statistics
        $today = Carbon::today();

        $stats = [
            'today_visits' => RekamMedis::whereDate('created_at', $today)->count(),
            'active_patients' => Pet::whereHas('rekamMedis', function($query) use ($today) {
                $query->where('rekam_medis.created_at', '>=', $today->copy()->subDays(7));
            })->count(),
            'pending_examinations' => 3, // You can customize this based on your examination system
        ];

        // Get today's examinations
        $today_examinations = RekamMedis::with(['temuDokter.pet.pemilik'])
            ->whereDate('created_at', $today)
            ->orderBy('idrekam_medis', 'desc')
            ->take(10)
            ->get();

        // Get upcoming appointments (placeholder - customize based on your system)
        $upcoming_appointments = []; // You can implement this based on your appointment model

        // Get recent medical records
        $recent_records = RekamMedis::with(['temuDokter.pet.pemilik'])
            ->orderBy('idrekam_medis', 'desc')
            ->take(5)
            ->get();

        return view('dokter.dashboard', compact(
            'stats',
            'today_examinations',
            'upcoming_appointments',
            'recent_records'
        ));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStats()
    {
        $today = Carbon::today();

        return response()->json([
            'today_visits' => RekamMedis::whereDate('created_at', $today)->count(),
            'active_patients' => Pet::whereHas('rekamMedis', function($query) use ($today) {
                $query->where('rekam_medis.created_at', '>=', $today->copy()->subDays(7));
            })->count(),
            'pending_examinations' => 3, // Customize based on your system
        ]);
    }
}

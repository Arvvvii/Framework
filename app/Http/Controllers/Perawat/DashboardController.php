<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Pet;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the perawat dashboard.
     */
    public function index()
    {
        // Get today's statistics
        $today = Carbon::today();

        $stats = [
            'today_treatments' => 12, // You can customize this based on your treatment system
            'active_patients' => Pet::whereHas('rekamMedis', function($query) use ($today) {
                $query->whereDate('created_at', '>=', $today->copy()->subDays(7));
            })->count(),
            'pending_treatments' => 2, // You can customize this based on your treatment system
        ];

        // Get today's treatments (placeholder - customize based on your system)
        $today_treatments = []; // You can implement this based on your treatment model

        // Get upcoming treatments (placeholder - customize based on your system)
        $upcoming_treatments = []; // You can implement this based on your treatment model

        // Get recent treatments
        $recent_treatments = RekamMedis::with(['temuDokter.pet.pemilik'])
            ->orderBy('idrekam_medis', 'desc')
            ->take(5)
            ->get();

        return view('perawat.dashboard', compact(
            'stats',
            'today_treatments',
            'upcoming_treatments',
            'recent_treatments'
        ));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStats()
    {
        $today = Carbon::today();

        return response()->json([
            'today_treatments' => 12, // Customize based on your system
            'active_patients' => Pet::whereHas('rekamMedis', function($query) use ($today) {
                $query->whereDate('created_at', '>=', $today->copy()->subDays(7));
            })->count(),
            'pending_treatments' => 2, // Customize based on your system
        ]);
    }
}

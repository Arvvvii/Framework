<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\RekamMedis;
use App\Models\Pemilik;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the pemilik dashboard.
     */
    public function index()
    {
        // Get current user
        $user = auth()->user();

        // Get pemilik data
        $pemilik = Pemilik::where('iduser', $user->iduser)->first();

        if (!$pemilik) {
            // Handle case where pemilik data doesn't exist
            return view('pemilik.dashboard', [
                'stats' => [
                    'total_pets' => 0,
                    'this_month_visits' => 0,
                    'upcoming_appointments' => 0,
                ],
                'pets' => collect(),
                'recent_visits' => collect(),
                'upcoming_appointments' => collect(),
            ]);
        }

        // Get statistics
        $thisMonth = Carbon::now()->startOfMonth();

        $stats = [
            'total_pets' => Pet::where('idpemilik', $pemilik->idpemilik)->count(),
            'this_month_visits' => RekamMedis::whereHas('temuDokter.pet', function($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })->where('created_at', '>=', $thisMonth)->count(),
            'upcoming_appointments' => 1, // You can customize this based on your appointment system
        ];

        // Get user's pets
        $pets = Pet::with('rasHewan')->where('idpemilik', $pemilik->idpemilik)->get();

        // Get recent visits
        $recent_visits = RekamMedis::with(['temuDokter.pet'])
            ->whereHas('temuDokter.pet', function($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })
            ->orderBy('idrekam_medis', 'desc')
            ->take(5)
            ->get();

        // Get upcoming appointments (placeholder - customize based on your system)
        $upcoming_appointments = []; // You can implement this based on your appointment model

        return view('pemilik.dashboard', compact(
            'stats',
            'pets',
            'recent_visits',
            'upcoming_appointments'
        ));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStats()
    {
        $user = auth()->user();
        $pemilik = Pemilik::where('idDataUser', $user->iduser)->first();

        if (!$pemilik) {
            return response()->json([
                'total_pets' => 0,
                'this_month_visits' => 0,
                'upcoming_appointments' => 0,
            ]);
        }

        $thisMonth = Carbon::now()->startOfMonth();

        return response()->json([
            'total_pets' => Pet::where('idpemilik', $pemilik->idpemilik)->count(),
            'this_month_visits' => RekamMedis::whereHas('temuDokter.pet', function($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })->where('created_at', '>=', $thisMonth)->count(),
            'upcoming_appointments' => 1, // Customize based on your system
        ]);
    }
}

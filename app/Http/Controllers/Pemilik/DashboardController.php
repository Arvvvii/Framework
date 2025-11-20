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
        $userId = session('user_id');
        
        // Get pemilik data
        $pemilik = Pemilik::where('iduser', $userId)->first();

        if (!$pemilik) {
            $totalPets = 0;
            $totalRekamMedis = 0;
        } else {
            $totalPets = Pet::where('idpemilik', $pemilik->idpemilik)->count();
            $totalRekamMedis = RekamMedis::whereHas('temuDokter.pet', function($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })->count();
        }

        return view('pemilik.dashboard', compact('totalPets', 'totalRekamMedis'));
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

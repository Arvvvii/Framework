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
        // Get statistics
        $totalRekamMedis = RekamMedis::count();
        $totalTindakan = \App\Models\KodeTindakanTerapi::count();

        return view('perawat.dashboard', compact('totalRekamMedis', 'totalTindakan'));
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

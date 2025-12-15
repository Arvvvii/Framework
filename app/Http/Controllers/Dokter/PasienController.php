<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        // Dokter hanya melihat pasien yang pernah/akan ditangani olehnya
        $userId = session('user_id');
        $doctorRoleIds = RoleUser::where('iduser', $userId)->where('idrole', 2)->pluck('idrole_user');

        $pasiens = Pet::with('pemilik.user')
            ->whereHas('temuDokter', function($q) use ($doctorRoleIds) {
                $q->whereIn('idrole_user', $doctorRoleIds);
            })
            ->get();

        // If this route is accessed under the perawat route group, render perawat view
        if (request()->routeIs('perawat.*')) {
            return view('perawat.Pasien.index', compact('pasiens'));
        }

        return view('dokter.Pasien.index', compact('pasiens'));
    }
}

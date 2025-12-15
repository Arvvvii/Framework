<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pet)
    {
        // Batasi hanya rekam medis yang diperiksa oleh dokter yang sedang login
        $userId = session('user_id');
        $doctorRoleIds = RoleUser::where('iduser', $userId)->where('idrole', 2)->pluck('idrole_user');

        $rekamMedis = RekamMedis::whereHas('temuDokter', function($q) use ($pet) {
                $q->where('idpet', $pet);
            })
            ->whereIn('dokter_pemeriksa', $doctorRoleIds)
            ->with('temuDokter.pet.pemilik.user', 'temuDokter.pet.rasHewan', 'roleUser.user')
            ->get();
        $petData = \App\Models\Pet::with('pemilik.user', 'rasHewan.jenisHewan')->findOrFail($pet);
        return view('dokter.RekamMedis.index', compact('rekamMedis', 'petData'));
    }
}

<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temuDokter = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan', 'rekamMedis')
            ->orderBy('waktu_daftar', 'desc')
            ->get();
        return view('resepsionis.TemuDokter.index', compact('temuDokter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        // Ambil semua role_user yang merupakan dokter (idrole = 2) beserta relasi user
        $dokters = \App\Models\RoleUser::with('user')->where('idrole', 2)->where('status', 1)->get();
        return view('resepsionis.TemuDokter.create', compact('pets', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            // wajib pilih dokter aktif (role=2, status=1)
            'idrole_user_dokter' => [
                'required',
                Rule::exists('role_user', 'idrole_user')->where(function($q){
                    $q->where('idrole', 2)->where('status', 1);
                }),
            ],
        ]);

        // hitung nomor urut per tanggal reservasi (berdasarkan tanggal di waktu_daftar)
        $tanggal = Carbon::parse($request->waktu_daftar)->format('Y-m-d');
        $maxUrut = TemuDokter::whereDate('waktu_daftar', $tanggal)->max('no_urut');
        $nextNoUrut = (int)($maxUrut ?? 0) + 1;

        TemuDokter::create([
            'idpet' => $request->id_pet,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $request->idrole_user_dokter,
            'no_urut' => $nextNoUrut,
            'status' => '1', // default to '1' (Menunggu)
        ]);

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibuat!');
    }

    /**
     * Cancel (delete) the specified resource.
     */
    public function destroy($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->delete();

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibatalkan!');
    }
}

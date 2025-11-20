<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Pet; // Hapus atau jadikan komentar
use App\Models\Pemilik; // Tetap diperlukan untuk create/edit form
use App\Models\RasHewan; // Tetap diperlukan untuk create/edit form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class PetController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: $pets = Pet::with('pemilik', 'rasHewan')->get();
        // Menggunakan Query Builder dengan JOIN
        $pets = DB::table('pet AS p')
            ->leftJoin('pemilik AS pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user AS u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('ras_hewan AS rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->select('p.*', 'pm.no_wa AS pemilik_no_wa', 'pm.alamat AS pemilik_alamat', 'u.nama AS pemilik_nama', 'rh.nama_ras')
            ->get();
            
        return view('admin.Pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource. (Helper data tetap Eloquent)
     */
    public function create()
    {
        $pemiliks = Pemilik::all();
        $rashewans = RasHewan::all();
        return view('admin.Pet.create', compact('pemiliks', 'rashewans'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // GANTI: Pet::create($request->only([...]));
        DB::table('pet')->insert($request->only(['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'idpemilik', 'idras_hewan']));

        return redirect()->route('admin.pet.index')->with('success', 'Pet created successfully.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idpet) // Model Binding diganti
    {
        $pet = DB::table('pet')->where('idpet', $idpet)->first();
        if (!$pet) {
            abort(404);
        }
        // CATATAN: View SHOW harus diubah untuk menggunakan data relasi melalui Query Builder lagi, jika View membutuhkannya.
        return view('admin.Pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idpet) // Model Binding diganti
    {
        $pet = DB::table('pet')->where('idpet', $idpet)->first();
        if (!$pet) {
            abort(404);
        }
        
        $pemiliks = Pemilik::all();
        $rashewans = RasHewan::all();
        return view('admin.Pet.edit', compact('pet', 'pemiliks', 'rashewans'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idpet) // Model Binding diganti
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // GANTI: $pet->update($request->only([...]));
        DB::table('pet')
            ->where('idpet', $idpet)
            ->update($request->only(['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'idpemilik', 'idras_hewan']));

        return redirect()->route('admin.pet.index')->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idpet) // Model Binding diganti
    {
        // GANTI: $pet->delete();
        DB::table('pet')->where('idpet', $idpet)->delete();

        return redirect()->route('admin.pet.index')->with('success', 'Pet deleted successfully.');
    }
}
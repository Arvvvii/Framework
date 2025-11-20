<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;

class DetailRekamMedisController extends Controller
{
    public function create($rekamMedisId)
    {
        $rekamMedis = RekamMedis::findOrFail($rekamMedisId);
        $petId = request('pet');
        $kodeTindakan = KodeTindakanTerapi::all();
        return view('dokter.RekamMedis.Detail.create', compact('rekamMedis', 'petId', 'kodeTindakan'));
    }

    public function store(Request $request, $rekamMedisId)
    {
        $petId = request('pet');
        $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|string',
        ]);
        DetailRekamMedis::create([
            'idrekam_medis' => $rekamMedisId,
            'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
            'detail' => $request->detail,
        ]);
        return redirect()->route('dokter.rekammedis.detail.index', [$rekamMedisId, 'pet' => $petId])->with('success', 'Detail tindakan/terapi berhasil ditambahkan!');
    }

    /**
     * Display a listing of the resource (detail records for a Rekam Medis).
     */
    public function index($rekamMedisId)
    {
        $rekamMedis = RekamMedis::with('detailRekamMedis.kodeTindakanTerapi')->findOrFail($rekamMedisId);
        $petId = request('pet');
        return view('dokter.RekamMedis.Detail.show', compact('rekamMedis', 'petId'));
    }

    /**
     * Display the specified detail resource. For compatibility with resource routes,
     * redirect to the index/listing unless a dedicated single-detail view is desired.
     */
    public function show($rekamMedisId, $detailId)
    {
        $detail = DetailRekamMedis::with('kodeTindakanTerapi', 'rekamMedis')->findOrFail($detailId);
        $rekamMedis = RekamMedis::findOrFail($rekamMedisId);
        $petId = request('pet');
        return view('dokter.RekamMedis.Detail.show_single', compact('rekamMedis', 'detail', 'petId'));
    }

    /**
     * Show the form for editing the specified detail.
     */
    public function edit($rekamMedisId, $detailId)
    {
        $rekamMedis = RekamMedis::findOrFail($rekamMedisId);
        $detail = DetailRekamMedis::findOrFail($detailId);
        $kodeTindakan = KodeTindakanTerapi::all();
        $petId = request('pet');
        return view('dokter.RekamMedis.Detail.edit', compact('rekamMedis', 'detail', 'kodeTindakan', 'petId'));
    }

    /**
     * Update the specified detail in storage.
     */
    public function update(Request $request, $rekamMedisId, $detailId)
    {
        $petId = request('pet');
        $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|string',
        ]);
        $detail = DetailRekamMedis::findOrFail($detailId);
        $detail->update([
            'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
            'detail' => $request->detail,
        ]);
        return redirect()->route('dokter.rekammedis.detail.index', [$rekamMedisId, 'pet' => $petId])->with('success', 'Detail tindakan/terapi berhasil diperbarui!');
    }

    /**
     * Remove the specified detail from storage.
     */
    public function destroy($rekamMedisId, $detailId)
    {
        $petId = request('pet');
        $detail = DetailRekamMedis::findOrFail($detailId);
        $detail->delete();
        return redirect()->route('dokter.rekammedis.detail.index', [$rekamMedisId, 'pet' => $petId])->with('success', 'Detail tindakan/terapi berhasil dihapus!');
    }
    // End CRUD for detail rekam medis
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RasHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rashewans = RasHewan::with('jenisHewan')->get();
        return view('admin.RasHewan.index', compact('rashewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenishawans = JenisHewan::all();
        return view('admin.RasHewan.create', compact('jenishawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ras' => 'required|string|max:255',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        RasHewan::create($request->only(['nama_ras', 'idjenis_hewan']));

        return redirect()->route('admin.rashewan.index')->with('success', 'RasHewan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RasHewan $rashewan)
    {
        $rashewan->load('jenisHewan');
        return view('admin.RasHewan.show', compact('rashewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RasHewan $rashewan)
    {
        $jenishawans = JenisHewan::all();
        return view('admin.RasHewan.edit', compact('rashewan', 'jenishawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RasHewan $rashewan)
    {
        $validator = Validator::make($request->all(), [
            'nama_ras' => 'required|string|max:255',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $rashewan->update($request->only(['nama_ras', 'idjenis_hewan']));

        return redirect()->route('admin.rashewan.index')->with('success', 'RasHewan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RasHewan $rashewan)
    {
        $rashewan->delete();

        return redirect()->route('admin.rashewan.index')->with('success', 'RasHewan deleted successfully.');
    }
}

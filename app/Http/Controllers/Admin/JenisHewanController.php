<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenishawans = JenisHewan::all();
        return view('admin.JenisHewan.index', compact('jenishawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.JenisHewan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        JenisHewan::create($request->only(['nama_jenis_hewan']));

        return redirect()->route('admin.jenishawan.index')->with('success', 'JenisHewan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisHewan $jenishawan)
    {
        return view('admin.JenisHewan.show', compact('jenishawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisHewan $jenishawan)
    {
        return view('admin.JenisHewan.edit', compact('jenishawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisHewan $jenishawan)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan,' . $jenishawan->idjenis_hewan . ',idjenis_hewan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jenishawan->update($request->only(['nama_jenis_hewan']));

        return redirect()->route('admin.jenishawan.index')->with('success', 'JenisHewan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisHewan $jenishawan)
    {
        $jenishawan->delete();

        return redirect()->route('admin.jenishawan.index')->with('success', 'JenisHewan deleted successfully.');
    }
}

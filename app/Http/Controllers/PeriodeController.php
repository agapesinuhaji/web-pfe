<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodes = Periode::all();

        return view('periodes.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:active,nonactive,done',
        ]);

        Periode::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('periode.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periode $periode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,nonactive,done',
        ]);

        // Cari data periode berdasarkan ID
        $periode = Periode::findOrFail($id);

        // Update data
        $periode->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('periode.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        //
    }
}

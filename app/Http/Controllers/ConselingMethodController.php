<?php

namespace App\Http\Controllers;

use id;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ConselingMethod;

class ConselingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        

        ConselingMethod::create([
            'user_id' => $request->user_id,
            'name' => $request->method,
            'status' => true,
        ]);

        return redirect()->route('user.show', $request->user_id)->with('success', 'Method added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $idData = ConselingMethod::find($id);
        
        $idData->update([
            'status' => !$idData->status,
        ]);

        $message = $idData->status ? 'Method has been enabled!' : 'Method has been disabled!';

        return redirect()->route('user.show', $idData->user_id)->with(['success' => $message]);
    }
}

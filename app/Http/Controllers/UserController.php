<?php

namespace App\Http\Controllers;

use App\Models\ConselingMethod;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $methods = ConselingMethod::where('user_id', $user->id)->get();


        return view('users.show', compact('user', 'methods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $status = $request->has('status') ? 1 : 0;

        
        $user->update([
            'role' => $request->role,
            'is_active' => $status, 
        ]);

        // redirect to show user
        return redirect('user/'. $user->id)->with(['success' => 'Your user has been updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active ? 'User has been enabled!' : 'User has been disabled!';

        return redirect('/user')->with(['success' => $message]);
    }

    public function schedule(User $user)
    {
        // Ambil jadwal berdasarkan user_id dan status 'ready'
        $schedules = Schedule::where('conselor_id', $user->id)->where('status', 'ready')->get();
        

        return view('users.schedule', compact('user', 'schedules'));
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $login = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($login->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        $methods = ConselingMethod::where('user_id', $user->id)->get();


        return view('users.show', compact('user', 'methods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        return view('users.edit', compact('user'));
    }


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

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        // Ambil jadwal berdasarkan user_id dan status 'ready'
        $schedules = Schedule::where('conselor_id', $user->id)->where('status', 'ready')->get();
        

        return view('users.schedule', compact('user', 'schedules'));
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cek role, jika bukan administrator logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login');
        } 

        $query = User::query()->with('profile');

        // Filter search jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%")
                ->orWhereHas('profile', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Pakai $query yang sudah difilter
        $users = $query->paginate(10)->withQueryString();

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

        $activities = Activity::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();


        return view('users.show', compact('user', 'methods', 'activities'));
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
        $oldRole = $user->role;

        $status = $request->has('status') ? 1 : 0;

        
        $user->update([
            'role' => $request->role,
            'is_active' => $status, 
        ]);

        $login = Auth::user();
        if ($oldRole !== $request->role) {
            // contoh: simpan ke activity log
            Activity::create([
                'user_id'     => $user->id,
                'title'       => 'Izin user diubah menjadi '. $user->role,
                'description' => "Role user {$user->profile->name} diubah dari {$oldRole} menjadi {$request->role} oleh {$login->profile->name}",
                'code' => '2',
            ]);
        }

        // redirect to show user
        return redirect()->route('user.show', $user->id)
                     ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);
        

        $message = $user->is_active ? 'User has been enabled!' : 'User has been disabled!';

        return redirect()->route('users.index')->with('success', $message);
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

<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyScheduleController extends Controller
{
   public function index()
    {
         $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'psikolog') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        // Ambil semua jadwal milik konselor
        $schedules = Schedule::where('conselor_id', Auth::id())
            ->with('product') // tambahkan eager load
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy('date'); // group by tanggal

        return view('myschedule.index', compact('schedules'));
    }
}

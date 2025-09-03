<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'administrator') {
            Auth::logout(); // opsional: logout user jika bukan admin
            return redirect()->route('login')->with('error', 'Permintaan terlarang.');
        }

        // Ambil tanggal hari ini
        $today = Carbon::today()->toDateString();

        // Ambil data orders dengan schedule hari ini dan status approved
        $todays = Order::select('orders.*')
            ->join('schedules', 'orders.schedule_id', '=', 'schedules.id')
            ->where('orders.status', 'approved')
            ->where('schedules.date', $today)
            ->orderBy('schedules.date', 'asc')
            ->orderBy('schedules.time', 'asc')
            ->with('schedule')
            ->get();

        // Ambil data orders dengan status progress
        $waitings = Order::with('schedule')
            ->where('status', 'progress')
            ->orderBy('updated_at', 'asc')
            ->get();

        // Ambil data orders dengan status progress
        $payeds = Order::with('schedule')
            ->where('status', 'payed')
            ->get();


        return view('dashboard', compact('todays', 'waitings', 'payeds'));
    }
}

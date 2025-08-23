<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyTaskController extends Controller
{
    public function index()
    {
        $orders = Order::where('conselor_id', Auth::id())->whereHas('schedule', function ($query) {
                    $query->whereDate('date', Carbon::today());
                    })->get();
        
                    
        // tasks hari ini
    $todayTasks = Order::where('conselor_id', Auth::id())
        ->whereHas('schedule', function ($query) {
            $query->whereDate('date', Carbon::today());
        })
        ->count();

    // tasks besok
    $tomorrowTasks = Order::where('conselor_id', Auth::id())
        ->whereHas('schedule', function ($query) {
            $query->whereDate('date', Carbon::tomorrow());
        })
        ->count();

        // tasks aktif (status = active, sesuaikan dengan kolom status di tabel order)
        $activeTasks = Order::where('conselor_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'progress'])
            ->count();

        // tasks selesai (status = done)
        $doneTasks = Order::where('conselor_id', Auth::id())
            ->where('status', 'selesai')
            ->count();
        
        return view('tasks.index', compact('orders', 'todayTasks', 'tomorrowTasks', 'activeTasks', 'doneTasks'));
    }

    public function show($order)
    {

        $order = Order::where('order_uuid', $order)->firstOrFail();

        return view('tasks.show', compact('order'));
    }

    public function all(Request $request)
    {
        $query = Order::where('conselor_id', Auth::id());

        // cek kalau ada parameter search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_uuid', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhereHas('schedule', function ($q2) use ($search) {
                    $q2->where('date', 'like', "%{$search}%")
                        ->orWhere('time', 'like', "%{$search}%");
                });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('tasks.all', compact('orders'));
    }

}

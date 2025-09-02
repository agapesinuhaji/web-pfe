<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Periode;
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


        // tasks aktif (status = active, sesuaikan dengan kolom status di tabel order)
        $activeTasks = Order::where('conselor_id', Auth::id())
            ->whereIn('status', ['pending', 'payed', 'approved', 'progress'])
            ->count();

        // tasks selesai (status = done)
        $doneTasks = Order::where('conselor_id', Auth::id())
            ->where('status', 'selesai')
            ->count();
        
        return view('tasks.index', compact('orders', 'todayTasks',  'activeTasks', 'doneTasks'));
    }

    public function show($order)
    {

        $order = Order::where('order_uuid', $order)->firstOrFail();

        // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();

        return view('tasks.show', compact('order', 'communications'));
    }

    public function all(Request $request)
    {
        $query = Order::where('conselor_id', Auth::id())->with('schedule');

        // Filter periode jika ada
        if ($request->has('periode') && $request->periode != 'all') {
            $periodeId = $request->periode;
            $query->whereHas('schedule', function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            });
        }

        // Filter search jika ada
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

        // Clone query untuk statistik
        $baseQuery = clone $query;

        $todayTasks = (clone $baseQuery)
            ->whereHas('schedule', function ($q) {
                $q->whereDate('date', Carbon::today());
            })->count();

        $activeTasks = (clone $baseQuery)
            ->whereIn('status', ['pending', 'payed', 'approved', 'progress'])
            ->count();

        $doneTasks = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $orders = $query->latest()->paginate(15)->withQueryString();

        $periodes = Periode::orderBy('start_date', 'desc')->get();

        return view('tasks.all', compact('orders', 'todayTasks', 'activeTasks', 'doneTasks', 'periodes'));
    }


}

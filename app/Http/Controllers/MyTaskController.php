<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Periode;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyTaskController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'psikolog') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        }        

        $orders = Order::where('conselor_id', Auth::id())
                    ->whereIn('status', ['approved', 'progress', 'selesai'])            
                    ->whereHas('schedule', function ($query) {
                        $query->whereDate('date', Carbon::today());
                    })->get();
        
                    
        // tasks hari ini
        $todayTasks = Order::where('conselor_id', Auth::id())
                        ->whereIn('status', ['approved', 'progress', 'selesai']) 
                        ->whereHas('schedule', function ($query) {
                            $query->whereDate('date', Carbon::today());
                        })
                        ->count();


        // tasks aktif (status = active, sesuaikan dengan kolom status di tabel order)
        $activeTasks = Order::where('conselor_id', Auth::id())
            ->whereIn('status', ['approved', 'progress'])
            ->count();

        // tasks selesai (status = done)
        $doneTasks = Order::where('conselor_id', Auth::id())
            ->where('status', 'selesai')
            ->count();
        
        return view('tasks.index', compact('orders', 'todayTasks',  'activeTasks', 'doneTasks'));
    }

    public function show($order)
    {

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'psikolog') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        }  

        $order = Order::where('order_uuid', $order)->firstOrFail();

        // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();

        $overtimes = Overtime::where('product_id', $order->product_id)->get(); 

        $order = Order::with('counselingResult')->findOrFail($order->id);


        return view('tasks.show', compact('order', 'communications', 'overtimes'));
    }

    public function all(Request $request)
    {

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'psikolog') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        }  

        $query = Order::where('conselor_id', Auth::id())
                ->whereIn('status', ['approved', 'progress', 'selesai'])         
                ->with('schedule');

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
                ->orWhereHas('user.profile', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('schedule', function ($q2) use ($search) {
                    $q2->where('date', 'like', "%{$search}%")
                        ->orWhere('time', 'like', "%{$search}%");
                });
            });
        }


        // Clone query untuk statistik
        $baseQuery = clone $query;

       
        $activeTasks = (clone $baseQuery)
            ->whereIn('status', ['approved', 'progress'])
            ->count();

        $doneTasks = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $orders = $query->latest()->paginate(15)->withQueryString();

        $periodes = Periode::orderBy('start_date', 'desc')->get();

        return view('tasks.all', compact('orders', 'activeTasks', 'doneTasks', 'periodes'));
    }


}

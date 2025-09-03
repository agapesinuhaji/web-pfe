<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

        $orders = Order::all();

        return view('orders.index', compact('orders'));
    }


    public function show($order)
    {
       
        
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        $order = Order::where('order_uuid', $order)->firstOrFail();
        // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();

        return view('orders.show', compact('order', 'communications'));
    }


    public function update(Request $request, Order $order)
    {
        // Validasi
        $request->validate([
            'status' => 'required|string|in:pending,payed,approved,progress,selesai',
        ]);

        $user = Auth::user();
        if (!in_array($user->role, ['administrator', 'psikolog'])) {
            abort(403, 'Akses ditolak');
        }

        // Update status
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

// Akhiri sesi order
    public function endSession($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'progress') {
            return redirect()->back()->with('error', 'Sesi tidak bisa diakhiri.');
        }

        $order->status = 'selesai'; // ganti sesuai status final
        $order->save();

        return redirect()->back()->with('success', 'Sesi berhasil diakhiri.');
    }



}

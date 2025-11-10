<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        if ($user->role !== 'user') {
            Auth::logout(); // opsional: logout user jika bukan admin
            return redirect()->route('login')->with('error', 'Permintaan terlarang.');
        }

        $orders = Order::where('user_id', Auth::id())->latest()->get();
        
        return view('orders.my-order', compact('orders'));
    }

    public function show($order)
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            Auth::logout(); // opsional: logout user jika bukan admin
            return redirect()->route('login')->with('error', 'Permintaan terlarang.');
        }

        $order = Order::where('order_uuid', $order)->firstOrFail();

         // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();
        

        return view('orders.show-order', compact('order', 'communications'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        
        return view('orders.my-order', compact('orders'));
    }

    public function show($order)
    {

        $order = Order::where('order_uuid', $order)->firstOrFail();

         // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();
        

        return view('orders.show-order', compact('order', 'communications'));
    }
}

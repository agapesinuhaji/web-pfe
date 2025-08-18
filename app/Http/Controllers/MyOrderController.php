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

    public function show(Order $order)
    {
        return view('orders.show-order');
    }
}

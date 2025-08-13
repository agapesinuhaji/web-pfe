<?php

namespace App\Http\Controllers;

use App\Models\ConselingMethod;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $conselors = User::with('profile')
            ->where('role', 'psikolog')
            ->where('is_active', 1)
            ->get();

            $products = Product::where('status', 1)->get();

            $methods = ConselingMethod::where('status', 1)->get();

        return view('checkout.index', compact('conselors', 'products', 'methods'));
    }
}

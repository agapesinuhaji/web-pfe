<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $periode = Periode::where('status', 'active')->firstOrFail();

        return view('transactions.index', compact('periode'));
    }
}

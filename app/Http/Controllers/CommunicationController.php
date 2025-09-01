<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Communication;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'message'  => 'required|string',
        ]);

        Communication::create([
            'order_id' => $validated['order_id'],
            'user_id'  => Auth::id(),
            'is_user'  => Auth::user()->role === 'user',
            'message'  => $validated['message'],
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}

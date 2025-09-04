<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonyController extends Controller
{
    public function store(Request $request)
    {


        // Validasi
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan ke database
        Testimony::create([
            'order_id' => $request->order_id,
            'user_id' => Auth::id(), // ambil user yang login
            'rating'  => $request->rating,
            'message' => $request->message,
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Terima kasih atas testimoni Anda!');
    }
}

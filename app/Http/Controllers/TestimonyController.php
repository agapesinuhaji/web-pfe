<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonyController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        }  

        // Ambil semua data payment_method
        $testimonies = Testimony::paginate(10);


        return view('testimony.index', compact('testimonies'));
    }

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

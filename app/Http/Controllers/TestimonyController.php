<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonyController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // Cek role, jika bukan administrator logout
        if (!in_array($user->role, ['administrator', 'psikolog'])) {
            Auth::logout();
            return redirect()->route('login');
        }

        // Query dasar
        $query = Testimony::with(['order.user.profile']);

        // Jika ada search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('order', function ($q) use ($search) {
                $q->where('order_uuid', 'like', "%{$search}%")
                ->orWhereHas('user.profile', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Urutkan terbaru & pagination
        $testimonies = $query->latest()->paginate(10)->withQueryString();

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

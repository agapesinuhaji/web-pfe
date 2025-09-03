<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OverTimeController extends Controller
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
        $overtime = Overtime::all();

        $products = Product::all();

        return view('overtime.index', compact('overtime', 'products'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'status' => 'required|in:0,1',
        ]);



        // Simpan data ke database
        Overtime::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'biaya' => $request->biaya,
            'is_active' => $request->status,
        ]);


        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // Ambil data lama
        $overtime = Overtime::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'status' => 'required|in:0,1',
        ]);


        // Update data lain
        $overtime->product_id = $request->product_id;
        $overtime->name = $request->name;
        $overtime->biaya = $request->biaya;
        $overtime->is_active = $request->status;

        $overtime->save();

        return redirect()->route('overtime.index');
    }

    public function toggleStatus($id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->is_active = !$overtime->is_active; // balikkan status
        $overtime->save();

        return redirect()->back();
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\CounselingResult;
use Illuminate\Support\Facades\Auth;

class CounselingResultController extends Controller
{
    public function store(Request $request)
    {
        // validasi data
        $validated = $request->validate([
            'order_id'     => 'required|exists:orders,id',
            'catatan'      => 'required|string',
            'dugaan'       => 'required|string|max:255',
            'rekomendasi'  => 'required|string',
            'overtime_id'  => 'required|exists:overtimes,id',
        ]);

        // simpan ke DB
        CounselingResult::create([
            'order_id'      => $validated['order_id'],
            'note'          => $validated['catatan'],
            'suspicion'     => $validated['dugaan'],
            'recommendation'=> $validated['rekomendasi'],
            'overtime_id'   => $validated['overtime_id'],
        ]);


        $message = "<p><strong>Catatan Hasil Konseling</strong></p>" 
                    . $validated['catatan'] .
                    "<br><p><strong>Perkiraan Sementara</strong></p><p>" 
                    . $validated['dugaan'] .
                    "</p><br><p><strong>Rekomendasi</strong></p>"
                    . $validated['rekomendasi'];

    
        //Insert to Communication
        Communication::create([
            'order_id' => $validated['order_id'],
            'user_id'  => Auth::id(),
            'is_user'  => Auth::user()->role === 'user',
            'message'  => $message,
        ]);


        // update status order
        $order = Order::find($validated['order_id']);
        if ($order) {
            $order->status = 'progress'; 
            $order->save();
        }

        // redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Hasil konseling berhasil disimpan.');
    }
}

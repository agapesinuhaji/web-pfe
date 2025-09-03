<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingResult;

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

        // update status order
        $order = \App\Models\Order::find($validated['order_id']);
        if ($order) {
            $order->status = 'progress'; 
            $order->save();
        }

        // redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Hasil konseling berhasil disimpan.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\CounselingResult;
use App\Models\Overtime;
use App\Models\OvertimeData;
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
        

        $overtime = Overtime::where('id', $request->overtime_id)->first();


        if ($overtime && $overtime->biaya != 0) {
            Activity::create([
                'user_id'     => $order->user_id,
                'title'       => 'Terdapat over time pada #'. strtoupper(substr($order->order_uuid, 0, 8)),
                'description' => "Terdapat over time kurang lebih ( {$overtime->name} ) dengan biaya sebesar Rp {$overtime->biaya}",
                'code'        => "4",
            ]);

            if ($order) {
            $order->status = 'overtime'; 
            $order->save();

            OvertimeData::create([
                'order_id'          => $order->id,
                'overtime_id'       => $overtime->id,
                'image'             => "",
                'status'            => "waiting",
            ]);

            $message = "Terdapat kelebihan waktu konseling selama {$overtime->name} dan dikenakan biaya sebesar Rp {$overtime->biaya}";

            $adminId = \App\Models\User::where('role', 'administrator')->first()->id;

            //Insert to Communication
            Communication::create([
                'order_id' => $validated['order_id'],
                'user_id'  => $adminId,
                'is_user'  => Auth::user()->role === 'user',
                'message'  => $message,
            ]);
        }
            
        }

        if ($order) {
            $order->status = 'progress'; 
            $order->save();
        }

        // redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Hasil konseling berhasil disimpan.');
    }
}

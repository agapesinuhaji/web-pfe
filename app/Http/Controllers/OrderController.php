<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Overtime;
use App\Models\Transaction;
use App\Models\OvertimeData;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\PaymentMethod;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Hpp;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cek role, jika bukan administrator logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login');
        } 

        $query = Order::with(['user.profile', 'conselor.profile', 'schedule']);

        // Filter search jika ada
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Cari berdasarkan user pemesan (order->user->profile->name)
                $q->whereHas('user.profile', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                // Atau cari berdasarkan nama psikolog (order->conselor->profile->name)
                ->orWhereHas('conselor.profile', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });
            });
        }

         // Sort
        if ($request->filled('sort')) {
            $direction = $request->get('direction', 'asc');
            if ($request->sort === 'bukti-bayar') {
                $query->orderByRaw("CASE WHEN image IS NULL OR image = '' THEN 1 ELSE 0 END {$direction}");
            }
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }



    public function show($order)
    {
       
        
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        $order = Order::where('order_uuid', $order)->firstOrFail();
        // ambil communications khusus berdasarkan order_id
        $communications = $order->communications()->with('user')->get();


        $activities = Activity::where('user_id', $order->user_id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('orders.show', compact('order', 'communications', 'activities'));
    }


    public function update(Request $request, Order $order)
    {


        // Validasi
        $request->validate([
            'status' => 'required|string|in:pending,payed,approved,progress,selesai',
        ]);

        $user = Auth::user();
        if (!in_array($user->role, ['administrator', 'psikolog'])) {
            abort(403, 'Akses ditolak');
        }

        $periode = Periode::where('status', 'active')->firstOrFail();


        // Update status
        $order->status = $request->status;
        $order->save();

        $orderId = strtoupper(substr($order->order_uuid, 0, 8));

        Transaction::create([
            'periode_id' => $periode->id,
            'type' => 'income',
            'amount' => $order->total,
            'description' => 'Pembayaran order #'.$orderId.' berhasil diterima',
        ]);

        $payment_method = PaymentMethod::where('id', $order->payment_method_id)->first();

         Activity::create([
            'user_id' => $order->user->id,
            'title' => 'Melakukan pembayaran #' . strtoupper(substr($order->order_uuid, 0, 8)),
            'description' => $order->user->profile->name. ' telah melakukan pembayaran melalui ' . $payment_method->name,
            'code' => '3',
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    // Akhiri sesi order

    public function endSession(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'proof'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🖼️ Upload bukti pembayaran
        $file = $request->file('proof');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/payment_proofs');
        if (!file_exists($destinationPath)) mkdir($destinationPath, 0775, true);
        $file->move($destinationPath, $filename);
        $proofPath = 'uploads/payment_proofs/' . $filename;

        // 📦 Ambil data order dan relasi
        $order = Order::with([
            'user.profile',
            'conselor.profile',
            'product',
            'schedule',
            'method',
        ])->findOrFail($id);

        $periode = Periode::where('status', 'active')->firstOrFail();
        $overtimeData = OvertimeData::where('order_id', $order->id)->first();

        // Ambil hasil konseling dari counseling_results
        $counselingResult = \App\Models\CounselingResult::where('order_id', $order->id)->first();

        // 💰 Update data overtime
        if ($overtimeData) {
            $overtimeData->update([
                'order_id'     => $order->id,
                'terbayarkan'  => $request->amount,
                'image'        => $proofPath,
                'status'       => 'payed',
            ]);
        }

        // ⛔ Jika status tidak progress
        if ($order->status !== 'progress') {
            return redirect()->back()->with('error', 'Sesi tidak bisa diakhiri.');
        }

        // 🧾 Update status order
        $order->status = 'selesai';
        $order->save();

        // 🪶 Data untuk laporan PDF
        $pdfData = [
            'order' => $order,
            'result' => $counselingResult,
            'tanggal' => now()->format('d F Y'),
            'jumlah_bayar' => $request->amount,
            'keterangan' => 'Pembayaran overtime konseling telah diterima.',
        ];

        // 📄 Generate PDF dari Blade
        $pdf = Pdf::loadView('reports.hpp', $pdfData);

        $pdfDirectory = public_path('reports/hpp');
        if (!file_exists($pdfDirectory)) mkdir($pdfDirectory, 0775, true);

        $userName = preg_replace('/[^A-Za-z0-9\-]/', '_', $order->user->profile->name);
    // 🧾 Nama file PDF dengan nama user
        $pdfFileName = 'HPP-' . strtoupper(substr($order->order_uuid, 0, 8)) . '-' . $userName . '.pdf';
        $pdfPath = $pdfDirectory . '/' . $pdfFileName;

        // 💾 Simpan file PDF ke folder public/reports/hpp
        $pdf->save($pdfPath);

        // 🗃️ Simpan path ke database
        Hpp::create([
            'order_id' => $order->id,
            'hpp_file' => 'reports/hpp/' . $pdfFileName,
        ]);

        // 💬 Buat notifikasi dan log aktivitas
        $message = "Pembayaran kelebihan waktu telah diterima sebesar {$request->amount}.";
        $adminId = \App\Models\User::where('role', 'administrator')->first()->id;

        Communication::create([
            'order_id' => $order->id,
            'user_id'  => $adminId,
            'is_user'  => Auth::user()->role === 'user',
            'message'  => $message,
        ]);

        Activity::create([
            'user_id' => $order->user_id,
            'title' => 'Pembayaran Overtime diterima #' . strtoupper(substr($order->order_uuid, 0, 8)),
            'description' => "Pembayaran overtime telah diterima sebesar {$request->amount}.",
            'code' => '3',
        ]);

        Transaction::create([
            'periode_id' => $periode->id,
            'type' => 'income',
            'amount' => $request->amount,
            'description' => 'Pembayaran order #' . strtoupper(substr($order->order_uuid, 0, 8)) . ' berhasil diterima',
            'order_id' => $order->id,
        ]);

        Activity::create([
            'user_id' => $order->user_id,
            'title' => 'Konseling telah selesai #' . strtoupper(substr($order->order_uuid, 0, 8)),
            'description' => 'Konseling telah selesai dilakukan.',
            'code' => '3',
        ]);


        

        Communication::create([
            'order_id' => $order->id,
            'user_id'  => $adminId,
            'is_user'  => Auth::user()->role === 'user',
            'message'  => "Berikut adalah Hasil Pemeriksaan Psikologis (HPP) anda. <br>
                        <a href='" . asset('reports/hpp/' . $pdfFileName) . "' 
                            target='_blank' 
                            style='color: blue; text-decoration: underline;'>
                            $pdfFileName
                        </a>",
        ]);



        return redirect()->back()->with('success', 'Sesi berhasil diakhiri dan laporan HPP telah tersimpan.');
    }






    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->link = $request->link;
        $order->status = $request->status;
        $order->save();




        if($request->status == "selesai")
        {
            // dd($order);

            // Ambil hasil konseling dari counseling_results
            $counselingResult = \App\Models\CounselingResult::where('order_id', $order->id)->first();

            // 🪶 Data untuk laporan PDF
            $pdfData = [
                'order' => $order,
                'result' => $counselingResult,
                'tanggal' => now()->format('d F Y'),
                'jumlah_bayar' => $request->amount,
                'keterangan' => 'Pembayaran overtime konseling telah diterima.',
            ];

            // 📄 Generate PDF dari Blade
            $pdf = Pdf::loadView('reports.hpp', $pdfData);

            $pdfDirectory = public_path('reports/hpp');
            if (!file_exists($pdfDirectory)) mkdir($pdfDirectory, 0775, true);

            $userName = preg_replace('/[^A-Za-z0-9\-]/', '_', $order->user->profile->name);
        // 🧾 Nama file PDF dengan nama user
            $pdfFileName = 'HPP-' . strtoupper(substr($order->order_uuid, 0, 8)) . '-' . $userName . '.pdf';
            $pdfPath = $pdfDirectory . '/' . $pdfFileName;

            // 💾 Simpan file PDF ke folder public/reports/hpp
            $pdf->save($pdfPath);

            // 🗃️ Simpan path ke database
            Hpp::create([
                'order_id' => $order->id,
                'hpp_file' => 'reports/hpp/' . $pdfFileName,
            ]);

            $adminId = \App\Models\User::where('role', 'administrator')->first()->id;

            Activity::create([
                'user_id' => $order->user_id,
                'title' => 'Konseling telah selesai #' . strtoupper(substr($order->order_uuid, 0, 8)),
                'description' => 'Konseling telah selesai dilakukan.',
                'code' => '3',
            ]);
            

            Communication::create([
                'order_id' => $order->id,
                'user_id'  => $adminId,
                'is_user'  => Auth::user()->role === 'user',
                'message'  => "Berikut adalah Hasil Pemeriksaan Psikologis (HPP) anda. <br>
                            <a href='" . asset('reports/hpp/' . $pdfFileName) . "' 
                                target='_blank' 
                                style='color: blue; text-decoration: underline;'>
                                $pdfFileName
                            </a>",
            ]);
        }

        return redirect()->back();

    }



}

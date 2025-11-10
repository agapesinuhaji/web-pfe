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
    // 🔒 Validasi input
    $request->validate([
        'amount' => 'required|numeric',
        'proof'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Ambil file dari request
    $file = $request->file('proof');

    // Buat nama file unik
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Tentukan folder tujuan
    $destinationPath = public_path('uploads/payment_proofs');

    // Pastikan folder ada, kalau belum buat
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0775, true);
    }

    // Pindahkan file ke folder tujuan
    $file->move($destinationPath, $filename);

    // Simpan path relatif untuk disimpan di database
    $proofPath = 'uploads/payment_proofs/' . $filename;


    // ✅ Ambil data order
    $order = Order::findOrFail($id);
    $periode = Periode::where('status', 'active')->firstOrFail();
    $overtimeData = OvertimeData::where('order_id', $order->id)->first();


    // ⚙️ Update data overtime
    $overtimeData->update([
        'order_id'     => $order->id,
        'terbayarkan'  => $request->amount,
        'image'        => $proofPath,
        'status'       => 'payed',
    ]);

    // 🚫 Cegah jika sesi tidak dalam status progress
    if ($order->status !== 'progress') {
        return redirect()->back()->with('error', 'Sesi tidak bisa diakhiri.');
    }

    // ✅ Update status order menjadi selesai
    $order->status = 'selesai';
    $order->save();


    // 💬 Buat pesan notifikasi
    $message = "Pembayaran kelebihan waktu telah diterima sebesar {$request->amount}.";

    $adminId = \App\Models\User::where('role', 'administrator')->first()->id;

    // 💬 Simpan komunikasi
    Communication::create([
        'order_id' => $order->id,
        'user_id'  => $adminId,
        'is_user'  => Auth::user()->role === 'user',
        'message'  => $message,
    ]);

    // 🧾 Catat aktivitas & transaksi
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

    return redirect()->back()->with('success', 'Sesi berhasil diakhiri.');
}



    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->link = $request->link;
        $order->status = $request->status;
        $order->save();

        return redirect()->back();

    }



}

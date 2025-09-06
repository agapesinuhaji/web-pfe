<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Activity;
use Illuminate\Http\Request;
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

        return view('orders.show', compact('order', 'communications'));
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

        // Update status
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

// Akhiri sesi order
    public function endSession($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'progress') {
            return redirect()->back()->with('error', 'Sesi tidak bisa diakhiri.');
        }

        $order->status = 'selesai'; // ganti sesuai status final
        $order->save();

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

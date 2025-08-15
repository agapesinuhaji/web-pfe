<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $conselors = User::with('profile')
            ->where('role', 'psikolog')
            ->where('is_active', 1)
            ->get();

            $products = Product::where('status', 1)->get();

            $methods = ConselingMethod::where('status', 1)->get();

        return view('checkout.index', compact('conselors', 'products', 'methods'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required',
            'nickname'      => 'required',
            'date_of_place' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:L,P', // L = Laki-laki, P = Perempuan
            'no_whatsapp'   => 'required|numeric|digits_between:9,15',
            'paket'         => 'required|exists:products,id',
            'method'        => 'required|exists:conseling_methods,id',
            'konselor'      => 'required|exists:users,id',
            'date'          => 'required',
            'selectedTime'  => 'required',
        ]);

        // Simpan ke database
        //Profile
        $user->profile()->update([
            'name'          => $request->name,
            'nickname'      => $request->nickname,
            'date_of_place' => $request->date_of_place,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'no_whatsapp'   => $request->no_whatsapp,
        ]);

        // Ambil harga produk berdasarkan ID paket
    $product = Product::findOrFail($request->paket);

        // Cari schedule berdasarkan konselor, tanggal, dan jam
    $schedule = Schedule::where('conselor_id', $request->konselor)
        ->where('date', $request->date)
        ->where('time', $request->selectedTime)
        ->firstOrFail();


        // Kode unik
        $uniqueCode = rand(300, 600);

        // Harga + Kode Unik
        $total = $product->price + $uniqueCode;

        $order = Order::create([
            'order_uuid' => (string) Str::uuid(),
            'user_id'    => auth()->id(),
            'product_id' => $request->paket,
            'conselor_id'=> $request->konselor,
            'schedule_id'=> $schedule->id, // Ambil dari hasil query
            'method_id'  => $request->method,
            'price'      => $product->price,
            'unique_kode'=> $uniqueCode,
            'total'      => $total,
            'status'     => 'pending',
        ]);


        $schedule->update([
            'status' => 'booked',
        ]);



        // return redirect()->back()->with('success', 'Jadwal berhasil dipesan!');
        return redirect()->route('checkout.payment', $order->order_uuid);
    }


    public function payment($order_uuid)
    {
        $order = Order::with(['product', 'method', 'conselor', 'schedule'])
                            ->where('order_uuid', $order_uuid)
                            ->firstOrFail();


        return view('checkout.payment', compact('order'));
    }
}

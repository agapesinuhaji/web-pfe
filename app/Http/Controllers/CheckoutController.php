<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ConselingMethod;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {

        // Pastikan user sudah login
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    // Hitung order aktif user
    $activeOrders = Order::where('user_id', $user->id)
        ->whereNotIn('status', ['selesai', 'pay fail'])
        ->count();

    if ($activeOrders >= 2) {
        return redirect()
            ->route('myorder.index')
            ->with('error', 'Setiap user hanya dapat memiliki 2 Orderan aktif.');
    }


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
            'domicile'      => 'required',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:L,P', // L = Laki-laki, P = Perempuan
            'no_whatsapp'   => 'required|numeric|digits_between:9,15',
            'paket'         => 'required|exists:products,id',
            'method_id'        => 'required|exists:conseling_methods,id',
            'konselor'      => 'required|exists:users,id',
            'date'          => 'required',
            'selectedTime'  => 'required',
        ]);


        

        // Simpan ke database
        //Profile
        $user->profile()->update([
            'name'          => $request->name,
            'nickname'      => $request->nickname,
            'domicile'      => $request->domicile,
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
            'user_id'    => $user->id,
            'product_id' => $request->paket,
            'conselor_id'=> $request->konselor,
            'schedule_id'=> $schedule->id, // Ambil dari hasil query
            'method_id'  => $request->method_id,
            'price'      => $product->price,
            'unique_kode'=> $uniqueCode,
            'total'      => $total,
            'status'     => 'pending',
            'expired_at' => now()->addMinutes(15),
        ]);


        $schedule->update([
            'status' => 'booked',
        ]);

        Activity::create([
            'user_id' => $user->id,
            'title' => 'Melakukan pemesanan #' . strtoupper(substr($order->order_uuid, 0, 8)),
            'description' => $request->name. ' telah melakukan pemesanan paket ' . $product->name,
            'code' => '1',
        ]);



        // return redirect()->back()->with('success', 'Jadwal berhasil dipesan!');
        return redirect()
    ->route('checkout.index')
    ->with([
        'success_checkout' => 'Checkout berhasil dibuat! Anda akan diarahkan ke halaman pembayaran.',
        'redirect_order' => $order->order_uuid,
    ]);

    }

    public function update(Request $request, $uuid)
    {
        $user = Auth::user();

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment_method_id' => 'required|not_in:0|exists:payment_methods,id',
        ]);
        

        // cari berdasarkan order_uuid, bukan id
        $order = Order::where('order_uuid', $uuid)->firstOrFail();


        if (now()->greaterThan($order->expired_at)) {
            // sudah lewat 15 menit
            $order->status = 'pay fail';
            $order->save();

            Activity::create([
                'user_id' => $user->id,
                'title' => 'Pembayaran kadaluarsa #' . strtoupper(substr($order->order_uuid, 0, 8)),
                'description' => $user->profile->name. ' tidak melakukan pembayaran hingga waktu habis',
                'code' => '5',
            ]);

            return back()->with('error', 'Pembayaran sudah kadaluarsa, silakan buat order baru.');
        }

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/payment_proofs'), $filename);

            // simpan ke database
            $order->image = 'uploads/payment_proofs/' . $filename;
            $order->payment_method_id = $request->payment_method_id;
            $order->status = 'payed'; // misalnya set status pesanan
            $order->save();
        }

        $payment_method = PaymentMethod::where('id', $request->payment_method_id)->first();


        
        Activity::create([
            'user_id' => $user->id,
            'title' => 'Melakukan pembayaran #' . strtoupper(substr($order->order_uuid, 0, 8)),
            'description' => $user->profile->name. ' telah melakukan pembayaran melalui ' . $payment_method->name,
            'code' => '3',
        ]);

        

        return redirect()->route('myorder.show', $uuid);


    }




    public function payment($order_uuid)
    {
        $order = Order::with(['product', 'method', 'conselor', 'schedule'])
                            ->where('order_uuid', $order_uuid)
                            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('myorder.index');
        }

        // Ambil payment method aktif
        $paymentMethods = PaymentMethod::where('is_active', 1)->get();

        return view('checkout.payment', compact('order', 'paymentMethods'))
        ->with([
            'success_payment' => 'Silakan lakukan pembayaran dalam waktu 15 menit.',
            'redirect_order'  => $order->order_uuid,
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        // Ambil semua data payment_method
        $paymentMethods = PaymentMethod::all();

        return view('payment.index', compact('paymentMethods'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'atas_nama' => 'required|string|max:255',
        'number' => 'required|digits_between:1,30', // hanya angka, panjang max 30
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    // Ambil file dari request
    $file = $request->file('image');

    // Generate nama file unik
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Tentukan path tujuan di dalam folder public
    $destinationPath = public_path('uploads/payment_methods');

    // Pastikan folder tujuan ada, kalau belum — buat
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0775, true);
    }

    // Pindahkan file ke folder tujuan
    $file->move($destinationPath, $filename);

    // Simpan data ke database
    PaymentMethod::create([
        'name' => $request->name,
        'atas_nama' => $request->atas_nama,
        'number' => $request->number,
        'image' => 'uploads/payment_methods/' . $filename, // path relatif agar mudah dipanggil di view
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Payment Method berhasil ditambahkan!');
}


    public function update(Request $request, $id)
    {
        // Ambil data lama
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'number' => 'required|digits_between:1,30',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // nullable, karena tidak wajib
            'status' => 'required|in:0,1',
        ]);

        // Jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($paymentMethod->image && Storage::disk('public')->exists($paymentMethod->image)) {
                Storage::disk('public')->delete($paymentMethod->image);
            }

            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('uploads/payment_methods', $filename, 'public');

            $paymentMethod->image = $imagePath;
        }

        // Update data lain
        $paymentMethod->name = $request->name;
        $paymentMethod->atas_nama = $request->atas_nama;
        $paymentMethod->number = $request->number;
        $paymentMethod->is_active = $request->status;

        $paymentMethod->save();

        return redirect()->route('paymentMethod.index')->with('warning', 'Payment Method berhasil diperbarui!');

    }


    public function toggleStatus($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->is_active = !$paymentMethod->is_active; // balikkan status
        $paymentMethod->save();

        return redirect()->back()->with('warning', 'Status Payment Method berhasil diubah!');

    }

}

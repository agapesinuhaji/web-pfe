<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Hpp;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class HppController extends Controller
{
    public function generatePdf($orderId)
    {
        $order = Order::findOrFail($orderId);

        // 1️⃣ Generate PDF dari view
        $pdf = Pdf::loadView('pdf.hpp', compact('order'));

        // 2️⃣ Tentukan nama file dan lokasi
        $fileName = 'hpp-' . $order->id . '-' . now()->format('YmdHis') . '.pdf';
        $path = 'reports/hpp/' . $fileName;

        // 3️⃣ Simpan file PDF ke storage (folder public)
        Storage::disk('public')->put($path, $pdf->output());

        // 4️⃣ Simpan data ke tabel hpp
        Hpp::create([
            'order_id' => $order->id,
            'hpp_file' => $path,
        ]);

        // 5️⃣ Tidak perlu download, cukup return success
        return response()->json([
            'success' => true,
            'message' => 'PDF berhasil digenerate dan disimpan.',
            'file_path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }
}

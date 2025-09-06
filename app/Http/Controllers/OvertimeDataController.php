<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Overtime;
use App\Models\OvertimeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeDataController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cek role, jika bukan administrator logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login');
        }

        // Query dasar dengan relasi
        $query = OvertimeData::with(['order', 'overtime']);

        // Jika ada search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('order', function ($q) use ($search) {
                $q->where('order_uuid', 'like', "%{$search}%");
            })->orWhereHas('overtime', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Urutkan dari terbaru
        $overtimeData = $query->latest()->paginate(10)->withQueryString();

        return view('overtime.overtime-data', compact('overtimeData'));
    }


    public function update(Request $request, OvertimeData $overtimeData)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:payed,waiting,cancel',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('overtime_images', 'public');
        }

        $overtimeData->update($validated);

        return redirect()
        ->route('overtimeData.index')
        ->with('success', 'Overtime data updated successfully.');
    }

    
}

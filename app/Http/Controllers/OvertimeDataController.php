<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Overtime;
use App\Models\OvertimeData;
use Illuminate\Http\Request;

class OvertimeDataController extends Controller
{
    public function index()
    {
        $overtimeData = OvertimeData::with(['order', 'overtime'])->latest()->paginate(10);
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

        return redirect()->route('overtimeData.index')->with('success', 'Overtime data updated successfully.');
    }

    
}

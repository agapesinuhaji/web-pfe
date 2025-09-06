<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
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

        $query = Periode::query();

        // Search berdasarkan name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }


        $periodes = $query->orderBy('created_at', 'desc')
                  ->paginate(10)
                  ->withQueryString();

        return view('periodes.index', compact('periodes'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,nonactive,done',
        ]);

         // Cek jika status yang dimasukkan 'active', pastikan tidak ada periode aktif lain
        if ($request->status === 'active') {
            $activePeriod = Periode::where('status', 'active')->first();
            if ($activePeriod) {
                return redirect()->back()->with('error', 'Sudah ada periode yang aktif. Hanya boleh 1 periode aktif.');
            }
        }

        Periode::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('periode.index');
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required|in:active,nonactive,done',
        ]);

        // Cek jika ingin menjadikan periode ini 'active'
        if ($request->status === 'active') {
            $activePeriod = Periode::where('status', 'active')->where('id', '!=', $id)->first();
            if ($activePeriod) {
                return redirect()->back()->with('error', 'Sudah ada periode yang aktif. Hanya boleh 1 periode aktif.');
            }
        }

        // Cari data periode berdasarkan ID
        $periode = Periode::findOrFail($id);

        // Update data
        $periode->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('periode.index');
    }

}

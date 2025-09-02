<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Ambil daftar jam untuk konselor + tanggal + optional produk
     */
    public function getSchedules(Request $request, $conselorId, $date)
    {
        

        $query = Schedule::where('conselor_id', $conselorId)
            ->where('date', $date)
            ->where('status', 'ready');

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $schedules = $query->orderBy('time')->pluck('time');

        return response()->json($schedules);
    }

    /**
     * Halaman daftar jadwal semua psikolog
     */
    public function index()
    {

        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        // mulai dari tanggal 26 bulan ini
        $startDate = Carbon::now()->day(26);
        if (Carbon::now()->day > 25) {
            $startDate = $startDate->addMonth();
        }

        // sampai tanggal 25 bulan depan
        $endDate = $startDate->copy()->addMonth()->day(25);

        // buat periode tanggal
        $dates = CarbonPeriod::create($startDate, $endDate);

        $psychologists = User::where('role', 'psikolog')->get();
        $schedules = Schedule::with('user')->latest()->get();

        return view('schedules.index', compact('psychologists', 'schedules', 'dates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'conselor_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'slots' => 'required|array',
        ]);

        $oldSchedules = Schedule::where('periode_id', $request->periode_id)
            ->where('conselor_id', $request->conselor_id)
            ->where('product_id', $request->product_id)
            ->get();

        $newSchedules = [];
        foreach ($request->slots as $date => $times) {
            foreach ($times as $time) {
                if ($time) {
                    $newSchedules[] = [
                        'periode_id'  => $request->periode_id,
                        'conselor_id' => $request->conselor_id,
                        'product_id'  => $request->product_id,
                        'date'        => $date,
                        'time'        => $time,
                    ];
                }
            }
        }

        // hapus jadwal lama yang tidak ada di input baru
        foreach ($oldSchedules as $old) {
            $exists = collect($newSchedules)->first(fn($new) => $new['date'] == $old->date && $new['time'] == $old->time);
            if (! $exists) {
                $old->delete();
            }
        }

        // tambah jadwal baru yang belum ada
        foreach ($newSchedules as $new) {
            $exists = Schedule::where($new)->exists();
            if (! $exists) {
                Schedule::create($new);
            }
        }

        return redirect()->route('schedule.show', $request->periode_id);
    }

    /**
     * Tampilkan jadwal per periode
     */
    public function show(Request $request, $periode_id)
    {
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        $periode = Periode::findOrFail($periode_id);
        $dates = CarbonPeriod::create($periode->start_date, $periode->end_date);

        $psychologists = User::where('role', 'psikolog')->get();
        $products = Product::where('status', 1)->get();

        $schedules = Schedule::query()
            ->when($request->conselor_id, fn($q) => $q->where('conselor_id', $request->conselor_id))
            ->when($request->product_id, fn($q) => $q->where('product_id', $request->product_id))
            ->where('periode_id', $periode_id)
            ->get()
            ->groupBy('date');

        return view('schedules.show', compact(
            'periode',
            'dates',
            'psychologists',
            'products',
            'schedules'
        ));
    }

    public function edit(Schedule $schedule) {}
    public function update(Request $request, Schedule $schedule) {}

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('schedule.index');
    }

    public function destroyByDate($date)
    {
        Schedule::where('date', $date)->delete();
        return redirect()->route('schedule.index');
    }
}

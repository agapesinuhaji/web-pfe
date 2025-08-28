<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getSchedules($conselorId, $date)
    {
        $schedules = Schedule::where('conselor_id', $conselorId)
            ->where('date', $date)
            ->where('status', 'ready')
            ->orderBy('time')
            ->pluck('time');

        return response()->json($schedules);
    }

    public function index()
    {

        // mulai dari tanggal 26 bulan ini
        $startDate = Carbon::now()->day(26);
        if (Carbon::now()->day > 25) {
            // kalau sudah lewat 25, loncat ke bulan depan
            $startDate = $startDate->addMonth();
        }

        // sampai tanggal 25 bulan depan
        $endDate = $startDate->copy()->addMonth()->day(25);

        // buat periode tanggal
        $dates = CarbonPeriod::create($startDate, $endDate);
        
        
        $psychologists = User::where('role', 'psikolog')->get(); // sesuaikan dengan strukturmu
        $schedules = Schedule::with('user')->latest()->get();

        return view('schedules.index', compact('psychologists', 'schedules', 'dates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'date' => 'required|date|after_or_equal:today',
    //         'times' => 'required|array|min:1',
    //     ]);

    //     foreach ($request->times as $time) {
    //         Schedule::create([
    //             'conselor_id' => $request->user_id,
    //             'date' => $request->date,
    //             'time' => $time,
    //         ]);
    //     }

    //     return redirect()->route('user.schedule', $request->user_id)->with('success', 'Jadwal berhasil dibuat.');

    // }

     public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'conselor_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'slots' => 'required|array',
        ]);

        // Ambil semua schedule lama
        $oldSchedules = Schedule::where('periode_id', $request->periode_id)
            ->where('conselor_id', $request->conselor_id)
            ->where('product_id', $request->product_id)
            ->get();

        // Kumpulkan semua jadwal baru dari input
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

        // Hapus jadwal lama yang tidak ada di input baru
        foreach ($oldSchedules as $old) {
            $exists = collect($newSchedules)->first(function ($new) use ($old) {
                return $new['date'] == $old->date && $new['time'] == $old->time;
            });

            if (! $exists) {
                $old->delete();
            }
        }

        // Tambah jadwal baru yang belum ada
        foreach ($newSchedules as $new) {
            $exists = Schedule::where($new)->exists();
            if (! $exists) {
                Schedule::create($new);
            }
        }

        return redirect()->route('schedule.show', $request->periode_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $periode_id)
    {
        // ambil periode
        $periode = Periode::findOrFail($periode_id);

        // buat range tanggal dari periode
        $dates = CarbonPeriod::create($periode->start_date, $periode->end_date);

        // data master
        $psychologists = User::where('role', 'psikolog')->get();
        $products = Product::where('status', 1)->get();

        // ambil jadwal sesuai filter (jika ada)
        $schedules = Schedule::query()
            ->when($request->conselor_id, function ($q) use ($request) {
                $q->where('conselor_id', $request->conselor_id);
            })
            ->when($request->product_id, function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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

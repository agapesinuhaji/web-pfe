<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $psychologists = User::where('role', 'psikolog')->get(); // sesuaikan dengan strukturmu
        $schedules = Schedule::with('user')->latest()->get();

        return view('schedules.create', compact('psychologists', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'times' => 'required|array|min:1',
        ]);

        foreach ($request->times as $time) {
            Schedule::create([
                'conselor_id' => $request->user_id,
                'date' => $request->date,
                'time' => $time,
            ]);
        }

        return redirect()->route('user.schedule', $request->user_id)->with('success', 'Jadwal berhasil dibuat.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
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

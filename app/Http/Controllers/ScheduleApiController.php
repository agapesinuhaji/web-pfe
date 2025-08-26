<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;

class ScheduleApiController extends Controller
{
    public function availableDates($id)
    {
        return Schedule::where('conselor_id', $id)
            ->where('status', 'ready')
            ->pluck('date')
            ->unique()
            ->values();
    }

    public function availableTimes($id, $date)
    {
        return Schedule::where('conselor_id', $id)
            ->where('date', $date)
            ->where('status', 'ready')
            ->pluck('time');
    }

    public function getMethods(User $conselor)
    {
        return $conselor->methods()->where('status', 1)->get();
    }

}

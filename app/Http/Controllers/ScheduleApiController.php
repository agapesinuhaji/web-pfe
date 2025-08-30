<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleApiController extends Controller
{
    public function availableDates($id, Request $request)
    {
        return Schedule::where('conselor_id', $id)
            ->when($request->product_id, function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
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

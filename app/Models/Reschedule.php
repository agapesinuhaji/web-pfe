<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reschedule extends Model
{
    protected $fillable = [
        'order_id',
        'schedule_id',
        'reschedule_id',
        'description',
        'description_admin',
        'status',
    ];
}

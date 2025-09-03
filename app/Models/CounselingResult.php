<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingResult extends Model
{
    protected $fillable = [
        'order_id',
        'note',
        'suspicion',
        'recommendation',
        'overtime_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }
}

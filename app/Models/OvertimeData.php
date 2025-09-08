<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeData extends Model
{
    protected $fillable = [
        'order_id',
        'overtime_id',
        'image',
        'status',
        'terbayarkan',
    ];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Overtime
    public function overtime()
    {
        return $this->belongsTo(Overtime::class);
    }
}

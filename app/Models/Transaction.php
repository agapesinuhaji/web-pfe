<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'periode_id',
        'type',
        'amount',
        'description',
        'order_id',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    protected $fillable = [
        'order_id',
        'message',
        'rating',
        'is_active',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

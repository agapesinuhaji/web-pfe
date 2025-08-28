<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'conselor_id',
        'periode_id',
        'product_id',
        'date',
        'time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'conselor_id');
    }
}

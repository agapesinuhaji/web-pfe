<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConselingMethod extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

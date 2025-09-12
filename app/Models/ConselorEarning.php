<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConselorEarning extends Model
{
    protected $fillable = [
        'counselor_id',
        'periode_id',
        'amount',
        'biaya_admin',
        'biaya_system',
        'description',
    ];

    /**
     * Relasi ke User (Counselor).
     */
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    /**
     * Relasi ke Periode.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}

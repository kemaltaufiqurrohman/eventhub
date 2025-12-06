<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'event_id',
        'user_id',
        'waktu_absen'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'quota',
        'organizer_id',
        'status',
        'certificate',
        'status_event',
        'certificate_template',
        'name_x',
        'name_y',
        'name_font_size',
        'name_color'
    ];

    public function organizer()
    {
        return $this->belongsTo(\App\Models\User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    

    // Hitung jumlah peserta
    public function getParticipantCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function participants()
    {
        return $this->hasMany(\App\Models\Registration::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getStatusEventAttribute($value)
    {
        $eventDate = \Carbon\Carbon::parse($this->date);

        // batas absensi adalah H+1
        $deadline = $eventDate->copy()->addDay()->endOfDay();

        if (now()->greaterThan($deadline)) {
            return 'Selesai';
        }

        return 'Berlangsung';
    }




    

}

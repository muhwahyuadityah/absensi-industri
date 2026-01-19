<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id',
        'area_id',
        'shift_id',
        'photo_path',
        'latitude',
        'longitude',
        'session_date',
        'session_time',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    // Relasi: session dibuat oleh supervisor (user dengan role Pengawas)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Relasi: session terkait dengan area (nullable untuk non-area)
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Relasi: session terkait dengan shift
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // Relasi: 1 session punya banyak attendance (detail per karyawan)
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
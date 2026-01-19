<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_night_shift',
    ];

    protected $casts = [
        'is_night_shift' => 'boolean',
    ];

    // Relasi: 1 shift punya banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi: 1 shift punya banyak attendance session
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }
}
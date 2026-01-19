<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi: 1 area punya banyak user (karyawan)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi: 1 area punya banyak attendance session
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }
}
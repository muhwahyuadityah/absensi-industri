<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_session_id',
        'employee_id',
        'status',
        'notes',
    ];

    // Relasi: attendance terkait dengan session
    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    // Relasi: attendance terkait dengan karyawan
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
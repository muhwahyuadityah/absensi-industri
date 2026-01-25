<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_path',
        'employee_type',
        'area_id',
        'shift_id',
        'department',
        'position',
        'employee_number',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relasi: user terkait dengan area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Relasi: user terkait dengan shift
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // Relasi: user sebagai karyawan punya banyak attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    // Relasi: user sebagai supervisor punya banyak attendance session
    public function supervisedSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'supervisor_id');
    }

    /**
 * Send the email verification notification (custom).
 */
public function sendEmailVerificationNotification()
{
    $this->notify(new \App\Notifications\VerifyEmailWithPassword);
}
}
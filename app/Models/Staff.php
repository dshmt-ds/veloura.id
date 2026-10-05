<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $fillable = [
        'name',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'staff_services',
            'staff_id',
            'service_id'
        );
    }

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

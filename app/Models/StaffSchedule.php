<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $table = 'staff_schedules';

    protected $fillable = [
        'staff_id',
        'schedule_date',
        'start_time',
        'end_time',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
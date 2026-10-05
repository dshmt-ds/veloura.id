<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'customer_id',
        'staff_id',
        'start_at',
        'end_at',
        'total_amount',
        'status',
        'payment_due_at',
        'customer_notes',
        'cancellation_reason',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'payment_due_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];


    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }


    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_id'
        );
    }


    public function items()
    {
        return $this->hasMany(
            BookingItem::class,
            'booking_id'
        );
    }
}
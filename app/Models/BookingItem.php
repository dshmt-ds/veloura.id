<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $table = 'booking_items';

    protected $fillable = [
        'booking_id',
        'service_id',
        'service_name',
        'price',
        'duration_minutes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_minutes' => 'integer',
    ];

    public function booking()
    {
        return $this->belongsTo(
            Booking::class,
            'booking_id'
        );
    }

    public function service()
    {
        return $this->belongsTo(
            Service::class,
            'service_id'
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_reference',
        'gateway_provider',
        'gateway_transaction_id',
        'payment_method',
        'amount',
        'currency',
        'status',
        'checkout_url',
        'expires_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Relasi ke model Booking
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relasi ke model PaymentEvent (Webhook Logs)
     */
    public function events(): HasMany
    {
        return $this->hasMany(PaymentEvent::class);
    }
}
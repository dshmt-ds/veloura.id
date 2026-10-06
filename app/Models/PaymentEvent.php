<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentEvent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'gateway_provider',
        'event_key',
        'payload',
        'processing_status',
        'processed_at',
        'error_message',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'name',
        'category',
        'price',
        'duration',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'status' => 'boolean',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class,'staff_services','service_id','staff_id');
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }
}   
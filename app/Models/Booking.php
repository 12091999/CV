<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'customer_id',
        'business_unit_id',
        'business_item_id',
        'title',
        'description',
        'event_date',
        'location',
        'quantity',
        'unit_price',
        'total_amount',
        'amount_paid',
        'booking_status',
        'payment_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'amount_paid' => 'decimal:2',
        ];
    }

    public function businessItem(): BelongsTo
    {
        return $this->belongsTo(BusinessItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function businessUnit(): BelongsTo
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}

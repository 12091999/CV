<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalog;
use App\Models\BusinessItem;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessUnit extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Item bisnis
     */
    public function items(): HasMany
    {
        return $this->hasMany(BusinessItem::class);
    }


    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
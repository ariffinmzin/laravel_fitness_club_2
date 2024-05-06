<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'membership_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_code',
        'remarks'
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'duitnowqr' => 'Duitnow QR',
        'creditcard' => 'Credit Card',
        'banktransfer' => 'Bank Transfer'
    ];

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value / 100, 2),
            set: fn($value) => $value * 100,
        );
    }

}

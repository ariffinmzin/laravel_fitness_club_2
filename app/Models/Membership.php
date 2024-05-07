<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;

    public const MEMBERSHIP_STATUS = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'expired' => 'Expired',
        'banned' => 'Banned',
        'cancelled' => 'Cancelled'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}

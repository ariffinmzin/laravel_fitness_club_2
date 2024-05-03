<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

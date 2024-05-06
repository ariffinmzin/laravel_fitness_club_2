<?php

namespace App\Models;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    public const DURATION_OPTIONS = [
        '1 day' => '1 day',
        '1 week' => '1 week',
        '1 month' => '1 month',
        '3 months' => '3 months',
        '6 months' => '6 months',
        '1 year' => '1 year'
    ];

    public const ACTIVE_OPTIONS = [
        '1' => 'Active',
        '0' => 'Inactive'
    ];

    protected $fillable = [
        'name',
        'code',
        'duration',
        'price',
        'active'
    ];

    protected function price(): Attribute
    {

        return Attribute::make(
            get: fn($value) => number_format($value / 100, 2),
            set: fn($value) => $value * 100
        );

    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public static function getFormattedPlans()
    {
        $plans = self::all();

        $formattedPlans = [];

        foreach ($plans as $plan) {
            $formattedPlans[$plan->id] = $plan->name . " (RM $plan->price - {$plan->duration})";

        }

        return $formattedPlans;

    }

    public static function getIdPriceJSON()
    {
        $plans = self::all();

        $associative_array = [];

        foreach ($plans as $plan) {
            $associative_array[$plan->id] = $plan->toArray();

        }
        return json_encode($associative_array);
    }
}

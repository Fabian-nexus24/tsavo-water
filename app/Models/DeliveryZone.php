<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $fillable = [
        'name', 'description', 'base_fee', 'per_km_rate', 'is_active'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'zone_id');
    }
}

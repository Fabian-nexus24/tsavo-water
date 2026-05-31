<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    protected $fillable = [
        'user_id', 'national_id', 'vehicle_type', 'vehicle_plate', 
        'availability', 'rating', 'total_deliveries'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number', 'user_id', 'zone_id', 'delivery_address', 
        'delivery_city', 'delivery_lat', 'delivery_lng', 
        'payment_method', 'payment_status', 'order_status', 
        'subtotal', 'delivery_fee', 'discount', 'total_amount', 
        'notes', 'cancelled_reason', 'delivered_at'
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zone()
    {
        return $this->belongsTo(DeliveryZone::class, 'zone_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $year = date('Y');
                // Temporarily assign a placeholder, we'll update it after saving to get the ID
                // Alternatively, count existing to generate
                $count = static::whereYear('created_at', $year)->count() + 1;
                $order->order_number = 'TWS-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}

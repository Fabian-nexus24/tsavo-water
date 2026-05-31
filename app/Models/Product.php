<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 
        'sale_price', 'cost_price', 'stock', 'min_stock_alert', 'image', 
        'gallery', 'weight', 'unit', 'status', 'is_featured', 'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

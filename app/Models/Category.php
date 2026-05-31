<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'sort_order', 'is_active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

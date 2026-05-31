<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar',
        'address', 'city', 'latitude', 'longitude', 'status', 'last_login_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSuperAdmin() { return $this->role === 'superadmin'; }
    public function isAdmin() { return in_array($this->role, ['admin', 'superadmin']); }
    public function isDriver() { return $this->role === 'driver'; }
    public function isCustomer() { return $this->role === 'customer'; }

    public function orders() { return $this->hasMany(Order::class); }
    public function cart() { return $this->hasMany(Cart::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function driverProfile() { return $this->hasOne(DriverProfile::class); }
    public function deliveriesAsDriver() { return $this->hasMany(Delivery::class, 'driver_id'); }

    public function scopeCustomers($query) { return $query->where('role', 'customer'); }
    public function scopeDrivers($query) { return $query->where('role', 'driver'); }
    public function scopeAdmins($query) { return $query->whereIn('role', ['admin', 'superadmin']); }
}

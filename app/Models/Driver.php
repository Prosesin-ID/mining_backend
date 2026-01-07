<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'own_type',
        'nama_pemilik',
        'status',
        'current_latitude',
        'current_longitude',
        'last_location_update',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi ke DriverMoney
     */
    public function driverMoney()
    {
        return $this->hasOne(DriverMoney::class);
    }

    /**
     * Relasi ke DriverRequest
     */
    public function driverRequests()
    {
        return $this->hasMany(DriverRequest::class);
    }

    /**
     * Relasi ke UnitTruck
     */
    public function unitTruck()
    {
        return $this->hasOne(UnitTruck::class);
    }

    public function logActivities()
    {
        return $this->hasMany(DriverLogActivity::class);
    }

    public function checkoutActivities()
    {
        return $this->hasMany(CheckoutActivity::class);
    }
}
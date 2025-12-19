<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'license_number',
    ];

    protected $hidden = [
        'password',
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
}
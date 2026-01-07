<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckPoint extends Model
{
    protected $fillable = [
        'name',
        'kategori',
        'latitude',
        'longitude',
        'radius',
        'status',
    ];

    public function driverLogActivities()
    {
        return $this->hasMany(DriverLogActivity::class);
    }

    public function checkoutActivities()
    {
        return $this->hasMany(CheckoutActivity::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverMoney extends Model
{
    protected $table = 'driver_moneys';

    protected $fillable = [
        'driver_id',
        'amount',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

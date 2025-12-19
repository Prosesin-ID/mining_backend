<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitTruck extends Model
{
    protected $fillable = [
        'no_unit',
        'plate_number',
        'bank_id',
        'driver_id',
        'bank_account_number',
        'status',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

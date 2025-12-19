<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRequest extends Model
{
    protected $fillable = [
        'request_type',
        'amount',
        'driver_id',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

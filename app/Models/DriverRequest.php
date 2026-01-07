<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRequest extends Model
{
    protected $fillable = [
        'request_type',
        'amount',
        'driver_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}

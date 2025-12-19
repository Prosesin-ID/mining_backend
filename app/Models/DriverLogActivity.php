<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLogActivity extends Model
{
    protected $table = 'driver_log_activities';
    protected $fillable = [
        'driver_id',
        'checkpoint_id',
        'status',
        'check_In',
        'check_Out',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }   

    public function checkPoint()
    {
        return $this->belongsTo(CheckPoint::class);
    }
}

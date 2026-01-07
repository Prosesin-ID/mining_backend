<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutActivity extends Model
{

    protected $table = 'checkout_activities';
    protected $fillable = [
        'driver_id',
        'checkout_time',
        'check_point_id',
        'nama_material',
        'jumlah_kubikasi',
        'nama_kernet',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function checkPoint()
    {
        return $this->belongsTo(CheckPoint::class, 'check_point_id');
    }
}

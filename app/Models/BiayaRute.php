<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaRute extends Model
{
    protected $fillable = [
        'from',
        'to',
        'biaya',
    ];
}

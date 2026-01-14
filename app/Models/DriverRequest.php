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

    /**
     * Get parsed checkout data from notes
     */
    public function getCheckoutDataAttribute()
    {
        if ($this->request_type === 'pemotongan' && $this->notes) {
            $decoded = json_decode($this->notes, true);
            // Jika decode berhasil dan ada checkout_log_id, return data
            if ($decoded && isset($decoded['checkout_log_id'])) {
                return $decoded;
            }
        }
        // Jika bukan JSON atau bukan pemotongan, return notes biasa
        return null;
    }

    /**
     * Get admin notes (for approved/rejected status)
     */
    public function getAdminNotesAttribute()
    {
        if ($this->status !== 'pending' && $this->notes) {
            $decoded = json_decode($this->notes, true);
            // Jika bukan JSON, berarti ini notes dari admin
            if (!$decoded || !isset($decoded['checkout_log_id'])) {
                return $this->notes;
            }
        }
        return null;
    }
}
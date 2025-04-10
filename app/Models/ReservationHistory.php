<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'gender',
        'remarks',
        'appointment_date',
        'appointment_time',
        'status',
    ];

    /**
     * Define the relationship with Reservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
}

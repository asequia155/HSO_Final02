<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'first_name',
            'last_name',
        'phone',
        'email',
        'gender',
        'remarks',
        'date_of_birth',
        'address',
        'occupation',
        'appointment_date',
        'appointment_time',
        'user_id',

    ];

    /**
     * Define the relationship with ReservationHistory.
     */
    public function history()
    {
        return $this->hasMany(ReservationHistory::class, 'reservation_id', 'id');

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'occupation',
        'phone',
        'date_of_birth',
        'address',
    ];

    public function prescriptions()
    {
        return $this->hasMany(PatientPrescription::class, 'patient_id');
    }
    
}

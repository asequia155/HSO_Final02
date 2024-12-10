<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPrescription extends Model
{
    use HasFactory;

    protected $table = 'patient_prescriptions';

    protected $fillable = [
        'patient_id',
        'rx',
        'od',
        'os',
        'add',
        'pd',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

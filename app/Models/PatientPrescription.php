<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'od',
        'os',
        'add',
        'pd',
        'remarks',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}

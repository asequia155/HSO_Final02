<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    // Add the new fields to the $fillable property
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'occupation',
        'phone',
        'date_of_birth',
        'address',
        'rx',
        'od',
        'os',
        'add',
        'pd',
    ];

}


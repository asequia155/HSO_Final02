<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    // Fields that can be mass-assigned
    protected $fillable = [
        'title',
        'message',
        'is_read',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends Model
{

    // Fields that can be mass-assigned
    protected $fillable = [
        'title',
        'message',
        'is_read',
    ];

}

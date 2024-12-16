<?php

// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'customer_name',
        'total',
        'discount_amount',
        'tax',
        'cart_items'
    ];

    // Define `cart_items` as an array for easy JSON handling
    protected $casts = [
        'cart_items' => 'array', // Automatically cast JSON data to an array
        'total' => 'float',      // Ensure total is handled as a float
        'tax' => 'decimal:2',
        'discount_amount' => 'float'
    ];
}

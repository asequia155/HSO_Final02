<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', // Foreign key to the transaction
        'product_name',   // Name of the product
        'price',          // Price of the product
        'quantity',       // Quantity of the product in the cart
    ];

    // Define the inverse of the relationship with the Transaction model
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

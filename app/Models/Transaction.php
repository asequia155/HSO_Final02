<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'total_amount',
        'discount_amount',
        'payment_method',
        'patient_id',
        'tax_amount', // Added tax field
    ];

    /**
     * Get the user who processed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the items associated with the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}

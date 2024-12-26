<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_code', // Add product_code to fillable attributes
        'name', 
        'price', 
        'category_id', 
        'description',
        'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($product) {
            // Check if the quantity drops to 10 or below and was previously above 10
            if ($product->quantity <= 10 && $product->getOriginal('quantity') > 10) {
                Notification::create([
                    'title' => 'Low Stock Alert',
                    'message' => "The product '{$product->name}' has a low stock quantity of {$product->quantity}.",
                    'is_read' => false,
                ]);
            }
        });
    }
}

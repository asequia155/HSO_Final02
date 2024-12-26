<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Models\Transaction;
use Log;
use Illuminate\Support\Arr;

class TransactionHistory extends Controller
{
    public function getTransactionReport(Request $request)
{
    // Fetch start_date and end_date from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Transaction::query();

    // Apply date range filter if both dates are provided
    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Order the transactions by 'created_at' in descending order
    $query->orderBy('created_at', 'desc');

    // Get the transactions
    $transactions = $query->get();

    // Initialize an empty array to count product sales
    $productSales = [];

    // Loop through transactions and aggregate product sales
    foreach ($transactions as $transaction) {
        $cartItems = json_decode($transaction->cart_items, true);
        if (!is_array($cartItems)) {
            continue;
        }
        foreach ($cartItems as $item) {
            if (isset($item['product_name'])) {
                $productName = $item['product_name'];
                $price = $item['price'] ?? 0; // Default to 0 if price is missing
                $quantity = $item['quantity'] ?? 0; // Default to 0 if quantity is missing
    
                // Initialize or update the product's sales data
                if (!isset($productSales[$productName])) {
                    $productSales[$productName] = [
                        'name' => $productName,
                        'total_sales' => 0,
                        'total_quantity' => 0,
                    ];
                }
    
                $productSales[$productName]['total_sales'] += $price * $quantity;
                $productSales[$productName]['total_quantity'] += $quantity;
            }
        }
    }
    

    // Convert product sales to a sorted array by quantity
    $bestSellingProducts = Arr::sort($productSales, function ($product) {
        return $product['total_quantity'];
    });

    return Inertia::render('Frontend/POS/GetTransactionHistory', [
        'transactions' => $transactions,
        'bestSellingProducts' => $bestSellingProducts, // Pass best-selling products to the frontend
    ]);
}

    
    
    
}
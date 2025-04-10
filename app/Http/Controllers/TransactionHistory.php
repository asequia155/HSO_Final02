<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

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

        // Get the transactions along with their related transaction_items and products
        $transactions = $query->with(['items.product', 'user'])->get();

        // Initialize an array to aggregate product sales
        $productSales = [];

        // Aggregate product sales
        foreach ($transactions as $transaction) {
            foreach ($transaction->items as $item) {
                $productName = $item->product->name ?? 'Unknown Product';
                $price = $item->price;
                $quantity = $item->quantity;

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

        // Find the top 5 best-selling products
        $bestSellingProducts = collect($productSales)
            ->sortByDesc('total_quantity') // Sort by total_quantity in descending order
            ->take(5) // Take the top 5 products
            ->values(); // Reset the keys

        // Prepare transactions with computed fields for frontend
        $formattedTransactions = $transactions->map(function ($transaction) {
            $transaction->tax = $transaction->total_amount * 0.12; // Assuming 12% VAT
            $transaction->discount_amount = $transaction->discount_amount ?? 0;
            $transaction->total = $transaction->total_amount + $transaction->tax - $transaction->discount_amount;
            return $transaction;
        });

        return Inertia::render('Frontend/POS/GetTransactionHistory', [
            'transactions' => $formattedTransactions,
            'productSales' => $productSales,
            'bestSellingProducts' => $bestSellingProducts,
            'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
        ]);
    }

}

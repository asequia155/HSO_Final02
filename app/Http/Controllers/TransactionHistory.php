<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Models\Transaction;
use Log;


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
    
        return Inertia::render('Frontend/POS/GetTransactionHistory', [
            'transactions' => $transactions,
        ]);
    }
    
    
    
}
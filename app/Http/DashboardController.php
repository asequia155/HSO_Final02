<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Product;
use Inertia\Inertia;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Role-based dashboard logic
        if ($user->hasRole('admin')) {

            
    
        return Inertia::render('AdminDashboard', [
            'totalPatients' => Patient::count(),
            'totalProducts' => Product::count(),
            'totalSales' => Transaction::sum('total'),
            'todayTotalSales' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
        ]);
    
        } elseif ($user->hasRole('clerk')) {
            return Inertia::render('ClerkDashboard', [
                'totalProducts' => Product::count(),
                'todayTotalSales' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            ]);
        }

        // Full rawboard logic for other use cases
        $patients = Patient::all();
        $products = Product::all();
        $totalPatients = Patient::count();
        $totalProducts = Product::count();
        $totalSales = Transaction::sum('total');
        $todayTotalSales = Transaction::whereDate('created_at', Carbon::today())->sum('total');
        $salesChart = Transaction::select('total', 'created_at')->get();

        return Inertia::render('rawboard', [
            'patients' => $patients,
            'products' => $products,
            'totalPatients' => $totalPatients,
            'totalProducts' => $totalProducts,
            'totalSales' => $totalSales,
            'todayTotalSales' => $todayTotalSales,
            'salesChart' => $salesChart,
        ]);
    }

    public function adminDashboard()
    {

        // Fetch the transaction totals grouped by date
        $salesChart = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total')
        ->groupBy('date')
        ->get()
        ->map(function ($item) {
            return [
                'label' => Carbon::parse($item->date)->format('F'), // Formatting the date to show month and year
                'value' => $item->total,
            ];
        });


    // Debugging line to verify data is being generated
    Log::info('Sales Chart Data:', $salesChart->toArray());

        return Inertia::render('AdminDashboard', [
            'totalPatients' => Patient::count(),
            'totalProducts' => Product::count(),
            'totalSales' => Transaction::sum('total'),
            'todayTotalSales' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            'salesChartData' => $salesChart->toArray(),
        ])->with('debug', true);
    }

    public function clerkDashboard()
    {
        return Inertia::render('ClerkDashboard', [
            'totalProducts' => Product::count(),
            'todayTotalSales' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            'totalSales' => Transaction::sum('total'),
        ]);
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Notification;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Models\Transaction;

class POSController extends Controller
{
    // This is the main page that renders the POS view with products and categories
    public function index()
{
    $products = Product::all();
    $categories = Category::all();

    return Inertia::render('Frontend/POS/Index', [
        'products' => $products,
        'categories' => $categories,
        'message' => session('message'),
        'message_type' => session('message_type'),
        'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),

    ]);
}

    // This is for fetching products in a raw JSON format (e.g., for AJAX)
    public function getProducts()
    {
        return response()->json(Product::all());
    }

    // This is for fetching categories in a raw JSON format (e.g., for AJAX)
    public function getCategories()
    {
        return response()->json(Category::all());
    }

    // This shows a single product details (for product detail page)
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Frontend/POS/Index', [
            'product' => $product,
        ]);
    }

//store
public function store(Request $request)
{

    logger($request->all()); // Log the incoming request
    // Validate the incoming data
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'patient_id' => 'nullable|exists:patients,id', // Add patient ID validation
        'total_amount' => 'required|numeric',
        'discount_amount' => 'nullable|numeric',
        'tax_amount' => 'required|numeric',
        'transaction_items' => 'required|array',
        'transaction_items.*.product_id' => 'required|exists:products,id',
        'transaction_items.*.quantity' => 'required|integer|min:1',
        'transaction_items.*.price' => 'required|numeric',
        'transaction_items.*.subtotal' => 'required|numeric',
    ]);

    // Begin a transaction
    DB::beginTransaction();

    try {
        foreach ($validated['transaction_items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            // Check if the product has available stock
            if ($product->quantity == 0) {
                throw new \Exception("The product {$product->name} is out of stock.");
            }

            $remainingQuantity = $item['quantity'];

            // Deduct the quantity from batches
            $batches = Batch::where('product_id', $product->id)
                ->where('quantity', '>', 0)
                ->orderBy('production_date') // Adjust to 'expiry_date' if required
                ->get();

            foreach ($batches as $batch) {
                if ($remainingQuantity <= 0) break;

                if ($batch->quantity >= $remainingQuantity) {
                    $batch->quantity -= $remainingQuantity;
                    $batch->save();
                    $remainingQuantity = 0;
                } else {
                    $remainingQuantity -= $batch->quantity;
                    $batch->quantity = 0;
                    $batch->save();
                }
            }

            // If stock is insufficient across all batches
            if ($remainingQuantity > 0) {
                throw new \Exception("Insufficient stock for {$product->name}.");
            }

            // Update product's total quantity
            $product->quantity = Batch::where('product_id', $product->id)->sum('quantity');
            $product->save();
        }

        // Create the transaction record
        $transaction = Transaction::create([
            'user_id' => auth()->id(), // Store the authenticated user's ID
            'customer_name' => $validated['customer_name'],
            'patient_id' => $validated['patient_id'] ?? null, // Link the transaction to the patient if provided
            'total_amount' => $validated['total_amount'],
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'tax_amount' => $validated['tax_amount'],
        ]);

        // Create transaction items
        foreach ($validated['transaction_items'] as $item) {
            $transaction->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Commit the transaction
        DB::commit();

        return redirect()->route('pos.index')
            ->with('message', 'Payment processed successfully!')
            ->with('message_type', 'success');
    } catch (\Exception $e) {
        // Rollback in case of error
        DB::rollBack();

        return redirect()->route('pos.index')
            ->with('message', $e->getMessage())
            ->with('message_type', 'error');
    }
}




public function getBestSellingProducts()
{
    // Get all transactions
    $transactions = Transaction::all();

    // Initialize an empty array for counting products
    $productCount = [];

    // Loop through transactions and count products in cart_items
    foreach ($transactions as $transaction) {
        foreach ($transaction->cart_items as $item) {
            if (isset($item['product_id'])) {
                $productCount[$item['product_id']] = ($productCount[$item['product_id']] ?? 0) + 1;
            }
        }
    }

    // Sort products by frequency (highest first)
    arsort($productCount);

    // Get product details (you'll need to adjust this part based on how you retrieve product details)
    $bestSellingProducts = [];
    foreach ($productCount as $productId => $count) {
        $bestSellingProducts[] = [
            'product' => Product::find($productId), // Assuming you have a Product model
            'sales' => $count
        ];
    }

    return inertia('BestSellingProducts', [
        'bestSellingProducts' => $bestSellingProducts
    ]);
}

public function getDailySalesSummary()
{
    $dailySales = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total_sales')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

    return inertia('DailySalesSummary', [
        'dailySales' => $dailySales
    ]);
}


public function getMonthlySalesSummary()
{
    $monthlySales = Transaction::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total_sales')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

    return inertia('MonthlySalesSummary', [
        'monthlySales' => $monthlySales
    ]);
}



}

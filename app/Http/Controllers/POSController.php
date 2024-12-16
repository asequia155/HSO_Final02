<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
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

    // Retrieve the transaction from flash data
    $transaction = session('transaction');

    return Inertia::render('Frontend/POS/Index', [
        'products' => $products,
        'categories' => $categories,
        'message' => session('message'),
        'message_type' => session('message_type'),
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
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'cart_items' => 'required|array',
            'cart_items.*.product_name' => 'required|string',
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);
    
        $discountAmount = $validated['discount_amount'] ?? 0;
    
        // Begin a transaction
        DB::beginTransaction();
    
        try {
            $updatedCartItems = [];
    
            // Deduct product quantities from inventory and add price to cart items
            foreach ($validated['cart_items'] as $item) {
                // Find the product by name or another unique identifier
                $product = Product::where('name', $item['product_name'])->first();
    
                if ($product) {
                    $product->quantity -= $item['quantity'];
    
                    // Prevent negative inventory
                    if ($product->quantity < 0) {
                        throw new \Exception("Insufficient stock for {$product->name}.");
                    }
    
                    $product->save();
    
                    // Add price to the cart item
                    $updatedCartItems[] = [
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => $product->price, // Add the price from the Product model
                    ];
                }
            }
    
            // Create the transaction record
            Transaction::create([
                'customer_name' => $validated['customer_name'],
                'total' => $validated['total'],
                'tax' => $validated['tax'],
                'discount_amount' => $discountAmount,
                'cart_items' => json_encode($updatedCartItems), // Save updated cart items with prices
            ]);
    
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

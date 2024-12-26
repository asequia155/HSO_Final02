<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{   
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $existingProductCodes = Product::pluck('product_code')->toArray(); // Fetch existing product codes

        return Inertia::render('Frontend/Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'existingProductCodes' => $existingProductCodes,
            'message' => session('message'),
            'message_type' => session('message_type'),
        ]);
    }

    public function search(Request $request)
    {
        // Search products by name
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->get();

        return response()->json($products);
    }

    public function filterByCategory($categoryId)
    {
        // Filter products by category
        $products = Product::where('category_id', $categoryId)->get();

        return response()->json($products);
    }

    public function create()
    {
        return Inertia::render('Frontend/Product/Create');
    }

    public function store(Request $request)
{
    // Validate the input data
    $validated = $request->validate([
        'product_code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
    ]);

    // Check if the product code already exists
    if (Product::where('product_code', $validated['product_code'])->exists()) {
        return redirect()->back()
            ->withErrors(['product_code' => 'Product code already exists.'])
            ->withInput();
    }

    // Create a new product
    Product::create($validated);

    return redirect()->route('products.index')
        ->with('message', 'Product added successfully.')
        ->with('message_type', 'success');
}


    

    public function edit(Product $product)
    {
        
        return Inertia::render('Frontend/Product/Edit', [
            'product' => $product,
            'categories' => Category::all(), // Ensure categories are available for the edit form
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:255', // Add validation for product_code
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string|max:500',
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'quantity' => 'required|integer|min:0', // Validate quantity
        ]);
    
        $product = Product::findOrFail($id);
    
        // Set a default category if category_id is not provided or invalid
        $validated['category_id'] = $validated['category_id'] ?? 'others'; // Adjust according to your category table
    
        $product->update($validated);
    
        return redirect()->route('products.index')
            ->with('message', 'Product updated successfully.')
            ->with('message_type', 'success');
    }

    public function addStock(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string|max:500',
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'quantity' => 'required|integer|min:0', // Validate if category exists
        ]);

        $product = Product::findOrFail($id);

        // Set a default category if category_id is not provided or invalid
        $validated['category_id'] = $validated['category_id'] ?? 'others'; // Adjust according to your category table

        $product->update($validated);

        return redirect()->route('products.index')
        ->with('message', 'Stock added successfully.')
        ->with('message_type', 'success');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
        ->with('message', 'Product deleted successfully.')
        ->with('message_type', 'success');
    }

    public function show()
{
    return app(CategoryController::class)->index(); // Call CategoryController logic
}
}

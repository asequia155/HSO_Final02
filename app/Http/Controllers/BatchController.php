<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class BatchController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::withCount('products')->get();
        $batches = Batch::with('product')->get(); // Assuming Batch has a relationship with Product

        return Inertia::render('Frontend/Product/BatchList', [
            'products' => $products,
            'categories' => $categories,
            'message' => session('message'),
            'message_type' => session('message_type'),
            'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
            'batches' => $batches->map(function ($batch) {
                return [
                    'created_at' => $batch->created_at,
                    'id' => $batch->id,
                    'batch_number' => $batch->batch_number,
                    'quantity' => $batch->quantity,
                    'production_date' => $batch->production_date,
                    'expiry_date' => $batch->expiry_date,
                    'product_name' => $batch->product ? $batch->product->name : 'Unknown', // Handle cases where product might be null
                    'category_id' => $batch->product ? $batch->product->category_id : null, // Include category ID
                    'category_name' => $batch->product && $batch->product->category ? $batch->product->category->name : 'Unknown', // Include category name
                ];
            }),
        ]);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'batch_number' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'production_date' => 'nullable|date',
        'expiry_date' => 'nullable|date',
    ]);

    // Find the batch to update
    $batch = Batch::findOrFail($id);

    // Update batch details
    $batch->update([
        'batch_number' => $validated['batch_number'],
        'quantity' => $validated['quantity'],
        'production_date' => $validated['production_date'],
        'expiry_date' => $validated['expiry_date'],
    ]);

    // Update the product quantity if required
    $product = $batch->product; // Assuming Batch has a relationship with Product
    if ($product) {
        // Adjust product quantity to reflect the new batch quantity
        $totalBatchQuantity = Batch::where('product_id', $product->id)->sum('quantity');
        $product->quantity = $totalBatchQuantity;
        $product->save();
    }

    return redirect()->route('batchList.index')
        ->with('message', 'Batch updated successfully.')
        ->with('message_type', 'success');
    }

    public function deleteBatch($id)
    {
        // Find the batch by its ID
        $batch = Batch::findOrFail($id);

        // Retrieve the associated product
        $product = $batch->product; // Assuming Batch has a relationship with Product

        // Delete the batch
        $batch->delete();

        // Recalculate the total quantity of the product based on remaining batches
        if ($product) {
            $totalBatchQuantity = Batch::where('product_id', $product->id)->sum('quantity');
            $product->quantity = $totalBatchQuantity;
            $product->save();
        }

        // Return success message
        return redirect()->route('batchList.index')
            ->with('message', 'Batch deleted successfully.')
            ->with('message_type', 'success');
    }

}

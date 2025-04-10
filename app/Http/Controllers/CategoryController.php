<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return Inertia::render('Frontend/Product/CategoryList', [
            'categories' => $categories,
            'message' => session('message'),
            'message_type' => session('message_type'),
            'notifications' => Notification::where('is_read', false)->latest()->take(3)->get(),
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Ensure the category name is required and a string
            'description' => 'nullable|string|max:500', // Allow optional description
        ]);

        // Create and store the new category in the database
        $category = Category::create([
            'name' => $validated['name'], // Insert the validated category name
            'description' => $validated['description'] ?? null, // Insert the optional description
        ]);

        // Return a response back to the frontend (Inertia)

        return redirect()->route('categories')
            ->with('message', 'Category added successfully.')
            ->with('message_type', 'success');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories')
            ->with('message', 'Category deleted successfully.')
            ->with('message_type', 'success');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500', // Allow optional description
        ]);

        $category = Category::findOrFail($id);

        $category->update($validated);

        return redirect()->route('categories')
            ->with('message', 'Category updated successfully.')
            ->with('message_type', 'success');
    }
}

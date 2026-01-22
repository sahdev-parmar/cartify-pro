<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->with('category')
            ->latest()
            ->paginate(12); 

        return view('category.index', compact('category', 'products'));
    }

    public function filterCategory(Request $request)
    {
        Log::info($request->all());
    }
}

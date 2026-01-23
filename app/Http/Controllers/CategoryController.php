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
        $categorySlug = $request->get('category');
        
        $category = Category::where('slug', $categorySlug)
            ->where('status', 1)
            ->firstOrFail();

        
        $query = Product::where('category_id', $category->id)
            ->with('category');
        
        if($request->has('search')){
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
         // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock filter
        if ($request->has('in_stock') && $request->in_stock == 1) {
            $query->where('stock_status', '=', 1);
        }

        // Sort filter
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }
        
         $products = $query->paginate(12);

        $html = view('category.product-grid', compact('products'))->render();
        
        return response()->json([
            'html' => $html,
        ]);
        
    }
}

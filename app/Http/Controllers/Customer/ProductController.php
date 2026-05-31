<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products for the customer.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', '!=', 'inactive')->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_low' => $query->orderBy('price', 'asc'),
                'price_high' => $query->orderBy('price', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                'popular' => $query->orderBy('sort_order', 'asc'),
                default => $query->orderBy('sort_order', 'asc'),
            };
        } else {
            $query->orderBy('sort_order', 'asc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();

        return view('customer.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', '!=', 'inactive')
            ->with('category')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('customer.products.show', compact('product', 'relatedProducts'));
    }
}

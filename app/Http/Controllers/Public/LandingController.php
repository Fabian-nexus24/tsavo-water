<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('status', 'active')
            ->with('category')
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $zones = DeliveryZone::where('is_active', true)->get();

        return view('public.index', compact('featuredProducts', 'categories', 'zones'));
    }

    /**
     * Display all products publicly.
     */
    public function products(Request $request)
    {
        $query = Product::where('status', 'active')->with('category');

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

        $products = $query->orderBy('sort_order')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.products', compact('products', 'categories'));
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('public.about');
    }
}

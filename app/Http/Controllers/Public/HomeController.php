<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DeliveryZone;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->take(4)
            ->get();
            
        $zones = DeliveryZone::where('is_active', true)
            ->take(6)
            ->get();

        return view('public.index', compact('featuredProducts', 'zones'));
    }
    
    public function products()
    {
        $products = Product::with('category')->where('status', 'active')->paginate(12);
        return view('public.products', compact('products'));
    }
    
    public function about()
    {
        return view('public.about');
    }
    
    public function contact()
    {
        return view('public.contact');
    }
}

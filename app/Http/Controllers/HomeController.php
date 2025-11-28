<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with all products
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // Filter by category if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();
        $selectedCategory = $request->get('category');

        return view('home', compact('products', 'selectedCategory'));
    }
}

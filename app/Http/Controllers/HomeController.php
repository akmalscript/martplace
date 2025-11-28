<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with all products
     */
    public function index()
    {
        $products = Product::active()
            ->latest()
            ->get();

        return view('home', compact('products'));
    }
}

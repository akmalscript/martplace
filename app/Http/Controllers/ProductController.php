<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(24);

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ]
            ]);
        }

        return view('products.index', compact('products'));
    }

    /**
     * Search suggestions (API endpoint)
     */
    public function search(Request $request)
    {
        $search = $request->input('q', '');

        if (strlen($search) < 2) {
            return response()->json(['suggestions' => []]);
        }

        // Get unique keywords from product names and descriptions
        $products = Product::active()
            ->search($search)
            ->limit(50)
            ->get(['name', 'description', 'category']);

        // Extract keywords
        $keywords = [];

        foreach ($products as $product) {
            // Split product name into words
            $words = preg_split('/\s+/', strtolower($product->name));
            foreach ($words as $word) {
                // Only include words that start with or contain the search term
                if (strlen($word) > 2 && stripos($word, strtolower($search)) !== false) {
                    $keywords[$word] = ($keywords[$word] ?? 0) + 1;
                }
            }

            // Add category if it matches
            if ($product->category && stripos(strtolower($product->category), strtolower($search)) !== false) {
                $category = strtolower($product->category);
                $keywords[$category] = ($keywords[$category] ?? 0) + 2;
            }
        }

        // Sort by frequency and get top 5
        arsort($keywords);
        $suggestions = array_slice(array_keys($keywords), 0, 5);

        return response()->json([
            'suggestions' => array_map(function($keyword) {
                return ucfirst($keyword);
            }, $suggestions)
        ]);
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::active()
            ->with(['reviews.user']) // load all reviews + the user who wrote them
            ->findOrFail($id);

        // Get related products
        $relatedProducts = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}

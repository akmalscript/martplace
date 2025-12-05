<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewSubmittedMail;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'comment' => 'nullable|string',
        ]);

        // Save review
        $review = Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province' => $request->province,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update product's average rating and total reviews
        $product = $review->product;
        $product->average_rating = $product->reviews()->avg('rating');
        $product->total_reviews = $product->reviews()->count();
        $product->save();

        // Send email (IMPORTANT FIX)
        Mail::to($review->email)->send(new ReviewSubmittedMail($review));

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}

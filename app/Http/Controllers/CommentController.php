<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentThankYou;

class CommentController extends Controller
{
    /**
     * Store a new comment and rating (SRS-MartPlace-06)
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validator = Validator::make($request->all(), Comment::validationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $comment = Comment::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        // Send thank you email
        try {
            Mail::to($request->email)->send(new CommentThankYou($comment, $product));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send thank you email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Terima kasih atas komentar dan rating Anda! Kami telah mengirimkan email konfirmasi.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isSeller()) {
            abort(403, 'Unauthorized action. Seller access required.');
        }

        // Check if seller has active seller account
        $seller = auth()->user()->seller;
        if (!$seller || !$seller->isActive()) {
            return redirect()->route('home')->with('error', 'Akun seller Anda belum aktif atau tidak ditemukan.');
        }

        return $next($request);
    }
}
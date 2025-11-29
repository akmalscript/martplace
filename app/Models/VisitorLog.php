<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_visited',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    /**
     * Log a visitor
     */
    public static function logVisitor($request, $page = null)
    {
        return self::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'page_visited' => $page ?? $request->path(),
            'visited_at' => now(),
        ]);
    }

    /**
     * Get unique visitors count
     */
    public static function uniqueVisitorsCount($startDate = null, $endDate = null)
    {
        $query = self::select('ip_address')->distinct();
        
        if ($startDate) {
            $query->where('visited_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('visited_at', '<=', $endDate);
        }
        
        return $query->count();
    }
}
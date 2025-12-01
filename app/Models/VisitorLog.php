<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorLog extends Model
{
    protected $fillable = [
        'visitor_email',
        'visitor_name',
        'visitor_province',
        'activity_type',
        'product_id',
        'product_review_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'activity_type' => 'string',
    ];

    /**
     * Get the product associated with the log
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the review associated with the log
     */
    public function productReview(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class);
    }
}

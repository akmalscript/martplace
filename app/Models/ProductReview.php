<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'visitor_name',
        'visitor_phone',
        'visitor_email',
        'visitor_province',
        'rating',
        'comment',
        'thank_you_email_sent',
        'email_sent_at',
        'is_visible',
    ];

    protected $casts = [
        'rating' => 'integer',
        'thank_you_email_sent' => 'boolean',
        'is_visible' => 'boolean',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Get the product that owns the review
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

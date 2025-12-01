<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'original_price',
        'stock',
        'image_url',
        'category',
        'rating',
        'sold_count',
        'location',
        'discount_percentage',
        'badge',
        'is_active',
        'has_variants',
        'min_order',
        'max_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
        'has_variants' => 'boolean',
        'min_order' => 'integer',
        'max_order' => 'integer',
    ];

    /**
     * Relationship: Product belongs to a Seller
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relationship: Product has many variants
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relationship: Product has many images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Get primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Scope: Search products by name
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                     ->orWhere('description', 'like', '%' . $search . '%')
                     ->orWhere('category', 'like', '%' . $search . '%');
    }

    /**
     * Scope: Only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Order by popularity
     */
    public function scopePopular($query)
    {
        return $query->orderBy('sold_count', 'desc');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format((float) $this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'Rp' . number_format((float) $this->original_price, 0, ',', '.') : null;
    }
}

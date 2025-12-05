<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_url',
        'average_rating',
        'total_reviews',
        'province',
        'city',
        'is_active',
        'has_variants',
        'min_order',
        'max_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'has_variants' => 'boolean',
        'min_order' => 'integer',
        'max_order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship: Product belongs to a Seller
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relationship: Product belongs to a Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
     * Relationship: Product has many reviews
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_visible', true);
    }

    /**
     * Relationship: Product has many visitor logs
     */
    public function visitorLogs()
    {
        return $this->hasMany(VisitorLog::class);
    }

    /**
     * Scope: Search products by name, description, category, seller name, and location
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('city', 'like', '%' . $search . '%')
              ->orWhere('province', 'like', '%' . $search . '%')
              // Search by category name
              ->orWhereHas('category', function ($categoryQuery) use ($search) {
                  $categoryQuery->where('name', 'like', '%' . $search . '%');
              })
              // Search by seller/store name or location
              ->orWhereHas('seller', function ($sellerQuery) use ($search) {
                  $sellerQuery->where('store_name', 'like', '%' . $search . '%')
                              ->orWhere('city', 'like', '%' . $search . '%')
                              ->orWhere('province', 'like', '%' . $search . '%')
                              ->orWhere('district', 'like', '%' . $search . '%');
              });
        });
    }

    /**
     * Scope: Only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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

    /**
     * Get image URL - prioritize primary image from images relation
     */
    public function getImageUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $primaryImage = $this->images()->where('is_primary', true)->first();
        if ($primaryImage) {
            return $primaryImage->image_path;
        }

        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_path;
        }

        return 'https://placehold.co/600x600/E5E5E5/999999?text=No+Image';
    }
}

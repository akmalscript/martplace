<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'category_id',
        'price',
        'stock',
        'description',
        'weight',
        'condition',
        'main_photo',      // foto utama
        'photos',          // array foto tambahan
        'variations',      // array variasi
        'status',          // ACTIVE / INACTIVE
        // field tambahan dari branch lain
        'original_price',
        'rating',
        'sold_count',
        'location',
        'discount_percentage',
        'badge',
        'is_active',
    ];

    protected $casts = [
        'photos' => 'array',
        'variations' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Product belongs to a Seller
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Product Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Search scope
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                     ->orWhere('description', 'like', '%' . $search . '%');
    }

    /**
     * Only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Order by popularity
     */
    public function scopePopular($query)
    {
        return $query->orderBy('sold_count', 'desc');
    }

    /**
     * Reviews Relationship
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Accessor formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price
            ? 'Rp' . number_format((float) $this->original_price, 0, ',', '.')
            : null;
    }
}

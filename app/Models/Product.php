<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'user_id',
        'name',
        'category_id',
        'price',
        'stock',
        'description',
        'weight',
        'condition',
        'main_photo',      
        'photos',        
        'variations',    
        'status',         
        'original_price',
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

    protected $appends = ['rating', 'sold_count', 'image_url', 'all_photos'];

    /**
     * Get the main image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->main_photo) {
            return asset('storage/' . $this->main_photo);
        }
        
        // Fallback to first photo in gallery
        if ($this->photos && count($this->photos) > 0) {
            return asset('storage/' . $this->photos[0]);
        }
        
        return 'https://placehold.co/300x300/D2DCB6/778873?text=No+Image';
    }

    /**
     * Get all product photos (main + gallery)
     */
    public function getAllPhotosAttribute()
    {
        $allPhotos = [];
        
        if ($this->main_photo) {
            $allPhotos[] = asset('storage/' . $this->main_photo);
        }
        
        if ($this->photos && is_array($this->photos)) {
            foreach ($this->photos as $photo) {
                $allPhotos[] = asset('storage/' . $photo);
            }
        }
        
        return $allPhotos;
    }

    /**
     * Relationship: Product belongs to a Seller
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relationship: Product belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Product Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Product Comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get average rating from comments
     */
    public function getRatingAttribute()
    {
        $avgRating = $this->comments()->avg('rating');
        return $avgRating ? round($avgRating * 10) : 0; // Scale to 50 (5.0 * 10)
    }

    /**
     * Get total comments count (as sold_count for now)
     */
    public function getSoldCountAttribute()
    {
        return $this->comments()->count();
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
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    /**
     * Low stock products (< 2)
     */
    public function scopeLowStock($query)
    {
        return $query->where('stock', '<', 2);
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

    /**
     * Get category name (fallback for old data)
     */
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'main_photo',
        'photos',
        'variations',
        'status',
    ];

    protected $casts = [
        'photos' => 'array',
        'variations' => 'array',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}

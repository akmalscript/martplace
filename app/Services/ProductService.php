<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Seller;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class ProductService
{
    /**
     * Validation rules for product creation (SRS-MartPlace-03)
     * Based on Tokopedia product elements
     */
    public static function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:100|max:999999999999',
            'original_price' => 'nullable|numeric|min:100',
            'stock' => 'required|integer|min:0|max:999999',
            'description' => 'required|string|min:20|max:5000',
            'weight' => 'nullable|numeric|min:0.01|max:500',
            'condition' => 'nullable|in:new,used',
            'main_photo' => 'required_without:existing_main_photo|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variations' => 'nullable|array',
            'variations.*.name' => 'required_with:variations|string|max:100',
            'variations.*.options' => 'required_with:variations|array',
        ];
    }

    /**
     * Create a new product for seller
     */
    public function createProduct(Seller $seller, array $data, ?UploadedFile $mainPhoto = null, array $photos = []): ?Product
    {
        try {
            $productData = $this->prepareProductData($seller, $data);

            // Handle main photo upload
            if ($mainPhoto) {
                $productData['main_photo'] = $mainPhoto->store('products/main', 'public');
            }

            // Handle additional photos
            if (!empty($photos)) {
                $photoPaths = [];
                foreach ($photos as $photo) {
                    if ($photo instanceof UploadedFile) {
                        $photoPaths[] = $photo->store('products/gallery', 'public');
                    }
                }
                $productData['photos'] = $photoPaths;
            }

            return Product::create($productData);
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update existing product
     */
    public function updateProduct(Product $product, array $data, ?UploadedFile $mainPhoto = null, array $photos = []): bool
    {
        try {
            $updateData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'price' => $data['price'],
                'original_price' => $data['original_price'] ?? null,
                'stock' => $data['stock'],
                'description' => $data['description'],
                'weight' => $data['weight'] ?? null,
                'condition' => $data['condition'] ?? 'new',
                'variations' => $data['variations'] ?? null,
            ];

            // Handle main photo update
            if ($mainPhoto) {
                if ($product->main_photo) {
                    Storage::disk('public')->delete($product->main_photo);
                }
                $updateData['main_photo'] = $mainPhoto->store('products/main', 'public');
            }

            // Handle additional photos
            if (!empty($photos)) {
                $existingPhotos = $product->photos ?? [];
                foreach ($photos as $photo) {
                    if ($photo instanceof UploadedFile) {
                        $existingPhotos[] = $photo->store('products/gallery', 'public');
                    }
                }
                $updateData['photos'] = $existingPhotos;
            }

            return $product->update($updateData);
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete product with associated files
     */
    public function deleteProduct(Product $product): bool
    {
        try {
            // Delete main photo
            if ($product->main_photo) {
                Storage::disk('public')->delete($product->main_photo);
            }

            // Delete gallery photos
            if ($product->photos) {
                foreach ($product->photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }

            return $product->delete();
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get products with filters (SRS-MartPlace-04, 05)
     */
    public function getFilteredProducts(array $filters = [], int $perPage = 24)
    {
        $query = Product::active()->with(['seller', 'category', 'comments']);

        // Search by name, description, store name, or location (SRS-05)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('seller', function ($sq) use ($search) {
                      $sq->where('store_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Filter by category name
        if (!empty($filters['category_name'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['category_name']);
            });
        }

        // Filter by seller
        if (!empty($filters['seller_id'])) {
            $query->where('seller_id', $filters['seller_id']);
        }

        // Filter by price range
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Filter by location (province/city)
        if (!empty($filters['location'])) {
            $query->where('location', 'like', "%{$filters['location']}%");
        }

        // Sorting
        $sortBy = $filters['sort'] ?? 'latest';
        switch ($sortBy) {
            case 'popular':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('comments', 'rating')->orderByDesc('comments_avg_rating');
                break;
            default:
                $query->latest();
        }

        return $query->paginate($perPage);
    }

    /**
     * Search products, sellers, and locations (SRS-MartPlace-05)
     */
    public function search(string $keyword, int $limit = 5): array
    {
        if (strlen($keyword) < 2) {
            return ['products' => [], 'sellers' => [], 'locations' => []];
        }

        // Search products
        $products = Product::active()
            ->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            })
            ->limit($limit)
            ->get(['id', 'name', 'price', 'main_photo', 'location']);

        // Search sellers
        $sellers = Seller::active()
            ->where(function ($q) use ($keyword) {
                $q->where('store_name', 'like', "%{$keyword}%")
                  ->orWhere('pic_city', 'like', "%{$keyword}%")
                  ->orWhere('pic_province', 'like', "%{$keyword}%");
            })
            ->limit(3)
            ->get(['id', 'store_name', 'pic_city', 'pic_province', 'rating', 'total_products']);

        // Search locations
        $locations = [];
        
        $provinces = Seller::active()
            ->where('pic_province', 'like', "%{$keyword}%")
            ->select('pic_province')
            ->distinct()
            ->limit(2)
            ->pluck('pic_province');

        foreach ($provinces as $province) {
            $locations[] = ['name' => $province, 'type' => 'province'];
        }

        $cities = Seller::active()
            ->where('pic_city', 'like', "%{$keyword}%")
            ->select('pic_city', 'pic_province')
            ->distinct()
            ->limit(3 - count($locations))
            ->get();

        foreach ($cities as $city) {
            $locations[] = [
                'name' => $city->pic_city,
                'province' => $city->pic_province,
                'type' => 'city'
            ];
        }

        return [
            'products' => $products,
            'sellers' => $sellers,
            'locations' => $locations
        ];
    }

    /**
     * Get related products by category
     */
    public function getRelatedProducts(Product $product, int $limit = 6)
    {
        return Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit($limit)
            ->get();
    }

    /**
     * Prepare product data for creation
     */
    protected function prepareProductData(Seller $seller, array $data): array
    {
        return [
            'seller_id' => $seller->id,
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'original_price' => $data['original_price'] ?? null,
            'stock' => $data['stock'],
            'description' => $data['description'],
            'weight' => $data['weight'] ?? null,
            'condition' => $data['condition'] ?? 'new',
            'location' => $seller->pic_city . ', ' . $seller->pic_province,
            'variations' => $data['variations'] ?? null,
            'is_active' => true,
        ];
    }

    /**
     * Get all categories with hierarchy
     */
    public function getCategories()
    {
        return ProductCategory::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();
    }

    /**
     * Toggle product active status
     */
    public function toggleStatus(Product $product): bool
    {
        $product->is_active = !$product->is_active;
        return $product->save();
    }
}

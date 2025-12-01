<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            // Basic product info
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            
            // Pricing
            $table->decimal('price', 15, 2);
            
            // Stock
            $table->integer('stock')->default(0);
            $table->integer('sold_count')->default(0);
            
            // Variant support
            $table->boolean('has_variants')->default(false);
            $table->integer('min_order')->default(1);
            $table->integer('max_order')->nullable();
            
            // Images
            $table->string('image_url')->nullable();
            
            // Rating (calculated from reviews)
            $table->decimal('average_rating', 3, 2)->default(0); // 0.00 to 5.00
            $table->integer('total_reviews')->default(0);
            
            // Location (for search by location - SRS-05)
            $table->string('province', 100)->nullable();
            $table->string('city', 100)->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes for search optimization (SRS-05)
            $table->index('name');
            $table->index('category_id');
            $table->index('seller_id');
            $table->index('province');
            $table->index('city');
            $table->index('average_rating');
            $table->index(['is_active', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

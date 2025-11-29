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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('seller_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 15, 2);
                $table->decimal('original_price', 15, 2)->nullable();
                $table->integer('stock')->default(0);
                $table->string('image_url')->nullable();
                $table->string('category')->nullable();
                $table->integer('rating')->default(0);
                $table->integer('sold_count')->default(0);
                $table->string('location')->nullable();
                $table->integer('discount_percentage')->default(0);
                $table->string('badge')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index('name');
                $table->index(['is_active', 'created_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

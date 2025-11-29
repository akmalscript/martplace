<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
            if (!Schema::hasColumn('products', 'original_price')) {
                $table->decimal('original_price', 15, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'image_url')) {
                $table->string('image_url')->nullable()->after('main_photo');
            }
            if (!Schema::hasColumn('products', 'rating')) {
                $table->integer('rating')->default(0)->after('variations');
            }
            if (!Schema::hasColumn('products', 'sold_count')) {
                $table->integer('sold_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('products', 'location')) {
                $table->string('location')->nullable()->after('sold_count');
            }
            if (!Schema::hasColumn('products', 'discount_percentage')) {
                $table->integer('discount_percentage')->default(0)->after('location');
            }
            if (!Schema::hasColumn('products', 'badge')) {
                $table->string('badge')->nullable()->after('discount_percentage');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['is_active', 'original_price', 'image_url', 'rating', 'sold_count', 'location', 'discount_percentage', 'badge'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

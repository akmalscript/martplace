<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('seller_id')->constrained('product_categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('products', 'main_photo')) {
                $table->string('main_photo')->nullable()->after('badge');
            }
            if (!Schema::hasColumn('products', 'photos')) {
                $table->json('photos')->nullable()->after('main_photo');
            }
            if (!Schema::hasColumn('products', 'variations')) {
                $table->json('variations')->nullable()->after('photos');
            }
            if (!Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 8, 2)->nullable()->after('stock');
            }
            if (!Schema::hasColumn('products', 'condition')) {
                $table->enum('condition', ['new', 'used'])->default('new')->after('weight');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'main_photo', 'photos', 'variations', 'weight', 'condition']);
        });
    }
};

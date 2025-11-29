<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Complete MartPlace Schema Migration
 * 
 * This migration ensures all required fields for SRS-MartPlace are present.
 * It safely adds columns only if they don't already exist.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Update sellers table with verification fields (SRS-MartPlace-01, 02)
        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'registered_at')) {
                $table->timestamp('registered_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('sellers', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('registered_at');
            }
            if (!Schema::hasColumn('sellers', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('sellers', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('rejected_at');
            }
            if (!Schema::hasColumn('sellers', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('rejection_reason');
            }
            if (!Schema::hasColumn('sellers', 'total_products')) {
                $table->integer('total_products')->default(0)->after('rating');
            }
        });

        // Update products table for complete Tokopedia-style fields (SRS-MartPlace-03)
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'main_photo')) {
                $table->string('main_photo')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('products', 'photos')) {
                $table->json('photos')->nullable()->after('main_photo');
            }
            if (!Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 10, 2)->nullable()->after('photos');
            }
            if (!Schema::hasColumn('products', 'condition')) {
                $table->enum('condition', ['new', 'used'])->default('new')->after('weight');
            }
            if (!Schema::hasColumn('products', 'variations')) {
                $table->json('variations')->nullable()->after('condition');
            }
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->after('id');
            }
            if (!Schema::hasColumn('products', 'min_order')) {
                $table->integer('min_order')->default(1)->after('stock');
            }
        });

        // Update comments table with province for location statistics (SRS-MartPlace-06, 08)
        if (Schema::hasTable('comments') && !Schema::hasColumn('comments', 'province')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->string('province')->nullable()->after('rating');
            });
        }

        // Create visitor_logs table for tracking (SRS-MartPlace-07)
        if (!Schema::hasTable('visitor_logs')) {
            Schema::create('visitor_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('seller_id')->nullable()->constrained()->nullOnDelete();
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->string('page_type')->default('product');
                $table->string('province')->nullable();
                $table->timestamps();
                
                $table->index(['product_id', 'created_at']);
                $table->index(['seller_id', 'created_at']);
            });
        }

        // Ensure product_categories table exists (SRS-MartPlace-03, 05)
        if (!Schema::hasTable('product_categories')) {
            Schema::create('product_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('product_categories')->nullOnDelete();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->index('parent_id');
                $table->index('is_active');
            });
        }

        // Add role column to users table if not exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'seller', 'user'])->default('user')->after('password');
            });
        }
    }

    public function down(): void
    {
        // Remove added columns from sellers
        Schema::table('sellers', function (Blueprint $table) {
            $columnsToRemove = ['registered_at', 'verified_at', 'rejected_at', 'rejection_reason', 'rating', 'total_products'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('sellers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Remove added columns from products
        Schema::table('products', function (Blueprint $table) {
            $columnsToRemove = ['category_id', 'main_photo', 'photos', 'weight', 'condition', 'variations', 'sku', 'min_order'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Remove province from comments
        if (Schema::hasColumn('comments', 'province')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('province');
            });
        }

        Schema::dropIfExists('visitor_logs');
    }
};

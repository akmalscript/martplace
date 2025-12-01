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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            
            // Visitor identification
            $table->string('visitor_email', 100);
            $table->string('visitor_name', 100)->nullable();
            $table->string('visitor_province', 100)->nullable();
            
            // Activity tracking
            $table->enum('activity_type', ['review', 'rating', 'view'])->default('view');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_review_id')->nullable()->constrained()->onDelete('set null');
            
            // Technical info
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('visitor_email');
            $table->index('activity_type');
            $table->index('visitor_province');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};

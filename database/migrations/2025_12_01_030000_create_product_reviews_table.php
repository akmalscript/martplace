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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Visitor information (SRS-06)
            $table->string('visitor_name', 100);
            $table->string('visitor_phone', 20);
            $table->string('visitor_email', 100);
            $table->string('visitor_province', 100);
            
            // Review content
            $table->integer('rating'); // 1-5 scale
            $table->text('comment')->nullable();
            
            // Email notification tracking
            $table->boolean('thank_you_email_sent')->default(false);
            $table->timestamp('email_sent_at')->nullable();
            
            // Status
            $table->boolean('is_visible')->default(true);
            
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('product_id');
            $table->index('rating');
            $table->index('visitor_province');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};

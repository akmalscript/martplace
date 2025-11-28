<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('product_categories');
            $table->integer('price');
            $table->integer('stock');
            $table->text('description');
            $table->integer('weight');
            $table->enum('condition', ['new', 'used'])->default('new');
            $table->string('main_photo')->nullable();
            $table->json('photos')->nullable();
            $table->json('variations')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

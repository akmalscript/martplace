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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('variant_type_1')->nullable(); // Misal: Warna
            $table->string('variant_value_1')->nullable(); // Misal: Merah
            $table->string('variant_type_2')->nullable(); // Misal: Ukuran
            $table->string('variant_value_2')->nullable(); // Misal: L
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
            
            $table->index(['product_id', 'variant_type_1', 'variant_value_1']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

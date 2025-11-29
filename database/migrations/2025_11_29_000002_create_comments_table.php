<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('phone', 20);
                $table->string('email');
                $table->text('comment');
                $table->tinyInteger('rating')->unsigned()->default(5);
                $table->string('province')->nullable();
                $table->timestamps();

                $table->index(['product_id', 'created_at']);
                $table->index('email');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

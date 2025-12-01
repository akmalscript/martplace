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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('store_name');
            $table->text('store_description')->nullable();
            $table->string('pic_name');
            $table->string('pic_phone');
            $table->string('pic_email');
            $table->string('password');
            $table->string('pic_street');
            $table->string('pic_rt');
            $table->string('pic_rw');
            $table->string('pic_village');
            $table->string('pic_district');
            $table->string('pic_city');
            $table->string('pic_province');
            $table->string('pic_ktp_number')->unique();
            $table->string('pic_photo_path')->nullable();
            $table->string('pic_ktp_file_path')->nullable();
            $table->enum('status', ['PENDING', 'ACTIVE', 'REJECTED'])->default('PENDING');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_products')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};

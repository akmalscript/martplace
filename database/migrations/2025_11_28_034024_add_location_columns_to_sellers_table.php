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
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('city')->nullable()->after('status');
            $table->string('province')->nullable()->after('city');
            $table->string('district')->nullable()->after('province');
            $table->decimal('rating', 3, 2)->default(0)->after('district');
            $table->integer('total_products')->default(0)->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['city', 'province', 'district', 'rating', 'total_products']);
        });
    }
};

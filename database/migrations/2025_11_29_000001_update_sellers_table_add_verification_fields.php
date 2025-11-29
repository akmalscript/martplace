<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['registered_at', 'verified_at', 'rejected_at', 'rejection_reason']);
        });
    }
};

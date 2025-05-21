<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('platform_accounts', function (Blueprint $table) {
            $table->boolean('is_active')->default(true); // Thêm cột is_active, mặc định là true (kết nối)
        });
    }

    public function down(): void
    {
        Schema::table('platform_accounts', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
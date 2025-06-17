<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('facebook_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('platform_id')->nullable()->after('id');

            // Nếu có quan hệ với bảng platforms
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('facebook_accounts', function (Blueprint $table) {
            $table->dropForeign(['platform_id']);
            $table->dropColumn('platform_id');
        });
    }

};

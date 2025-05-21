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
        Schema::table('ai_post_prompts', function (Blueprint $table) {
            $table->json('image_settings')->nullable()->after('posted_at');
        });
    }
    
    public function down()
    {
        Schema::table('ai_post_prompts', function (Blueprint $table) {
            $table->dropColumn('image_settings');
        });
    }
};

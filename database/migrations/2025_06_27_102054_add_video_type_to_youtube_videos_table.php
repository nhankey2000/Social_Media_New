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
        Schema::table('youtube_videos', function (Blueprint $table) {
            // Thêm cột video_type
            $table->enum('video_type', ['long', 'short'])
                ->default('long')
                ->after('status')
                ->comment('Loại video: long = Video dài, short = YouTube Shorts');

            // Thêm index để query nhanh hơn
            $table->index('video_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropIndex(['video_type']);
            $table->dropColumn('video_type');
        });
    }
};

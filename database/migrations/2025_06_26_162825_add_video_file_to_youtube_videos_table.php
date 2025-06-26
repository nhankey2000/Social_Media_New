<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoFileToYouTubeVideosTable extends Migration
{
    public function up(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropColumn('video_file');
        });
    }
}

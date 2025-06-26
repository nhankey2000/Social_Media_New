<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_account_id')->constrained('platform_accounts')->onDelete('cascade');
            $table->string('video_id')->nullable()->unique(); // ID video trên YouTube
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('category_id')->nullable();
            $table->string('status')->default('public'); // public, private, unlisted
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};

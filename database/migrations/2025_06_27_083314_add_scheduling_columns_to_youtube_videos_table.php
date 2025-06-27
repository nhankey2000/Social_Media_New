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
            // Cột 1: Thời gian lên lịch đăng video
            $table->timestamp('scheduled_at')->nullable()->after('status');

            // Cột 2: Trạng thái upload (pending/uploading/uploaded/failed)
            $table->enum('upload_status', ['pending', 'uploading', 'uploaded', 'failed'])
                ->default('pending')->after('scheduled_at');

            // Cột 3: Lưu lỗi khi upload thất bại
            $table->text('upload_error')->nullable()->after('upload_status');

            // Cột 4: Thời gian thực tế đăng video thành công
            $table->timestamp('uploaded_at')->nullable()->after('upload_error');

            // Index để tìm kiếm nhanh
            $table->index(['upload_status', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropIndex(['upload_status', 'scheduled_at']);
            $table->dropColumn(['scheduled_at', 'upload_status', 'upload_error', 'uploaded_at']);
        });
    }
};

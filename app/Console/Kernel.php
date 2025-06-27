<?php

namespace App\Console;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            Log::info('✅ Task schedule chạy OK lúc: ' . now());
        })->everyMinute();
        $schedule->command('posts:auto-post')->everyMinute();
        $schedule->command('prompts:process')->everyMinute();
        $schedule->command('analytics:sync')->everyMinute();
        $schedule->command('instagram:process')->everyMinute();
        // ========== THÊM COMMAND YOUTUBE ==========
        $schedule->command('youtube:upload-scheduled --limit=10')
            ->everyMinute()
            ->withoutOverlapping(10) // Tránh chạy đồng thời, timeout 10 phút
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/youtube-scheduler.log'));

        // Log hoạt động YouTube scheduler
        $schedule->call(function () {
            $pendingCount = \App\Models\YouTubeVideo::pendingUpload()->count();
            if ($pendingCount > 0) {
                Log::info("📹 YouTube Scheduler: Có {$pendingCount} video đang chờ upload");
            }
        })->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

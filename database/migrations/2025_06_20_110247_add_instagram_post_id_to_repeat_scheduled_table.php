<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstagramPostIdToRepeatScheduledTable extends Migration
{
    /**
     * Chạy migration để thêm cột.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repeat_scheduled', function (Blueprint $table) {
            $table->string('instagram_post_id')->nullable()->after('facebook_post_id');
        });
    }

    /**
     * Hoàn tác migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repeat_scheduled', function (Blueprint $table) {
            $table->dropColumn('instagram_post_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstagramPostIdToPostsAndPostReposts extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('posts', 'instagram_post_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('instagram_post_id')->nullable()->after('facebook_post_id');
            });
        }

        if (!Schema::hasColumn('post_reposts', 'instagram_post_id')) {
            Schema::table('post_reposts', function (Blueprint $table) {
                $table->string('instagram_post_id')->nullable()->after('facebook_post_id');
            });
        }
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('instagram_post_id');
        });

        Schema::table('post_reposts', function (Blueprint $table) {
            $table->dropColumn('instagram_post_id');
        });
    }
}

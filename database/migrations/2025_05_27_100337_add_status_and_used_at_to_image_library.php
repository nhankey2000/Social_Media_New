<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndUsedAtToImageLibrary extends Migration
{
    public function up()
    {
        Schema::table('image_library', function (Blueprint $table) {
            $table->enum('status', ['unused', 'used'])->default('unused')->after('type');
            $table->timestamp('used_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('image_library', function (Blueprint $table) {
            $table->dropColumn(['status', 'used_at']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAccessTokenColumnOnPlatformAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('platform_accounts', function (Blueprint $table) {
            $table->longText('access_token')->change();
        });
    }

    public function down()
    {
        Schema::table('platform_accounts', function (Blueprint $table) {
            $table->string('access_token', 255)->change(); // nếu cần rollback
        });
    }
}

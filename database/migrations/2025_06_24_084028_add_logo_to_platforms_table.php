<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToPlatformsTable extends Migration
{
    public function up()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
}

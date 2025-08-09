<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdDanhmucDataToDataPostTable extends Migration
{
    public function up()
    {
        Schema::table('data_post', function (Blueprint $table) {
            $table->unsignedBigInteger('id_danhmuc_data')->nullable();
            $table->foreign('id_danhmuc_data')->references('id')->on('danhmuc_data')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('data_post', function (Blueprint $table) {
            $table->dropForeign(['id_danhmuc_data']);
            $table->dropColumn('id_danhmuc_data');
        });
    }
}

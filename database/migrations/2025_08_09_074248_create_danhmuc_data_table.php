<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDanhmucDataTable extends Migration
{
    public function up()
    {
        Schema::create('danhmuc_data', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('danhmuc_data');
    }
}

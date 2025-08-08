<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->nullable(false);
            $table->text('content')->nullable(false);
            $table->enum('type', ['video', 'image'])->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_post');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kbgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lingkungan_id');
            $table->string('nama');
            $table->string('batasan_wilayah');
            $table->foreign('lingkungan_id')->references('id')->on('lingkungans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kbgs');
    }
};

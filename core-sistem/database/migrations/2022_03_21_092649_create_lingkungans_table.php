<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLingkungansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lingkungans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paroki_id');
            $table->string('nama');
            $table->string('batasan_wilayah');
            $table->foreign('paroki_id')->references('id')->on('parokis');
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
        Schema::dropIfExists('lingkungans');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('keluargas', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('id_kepala_keluarga');
        //     $table->unsignedBigInteger('lingkungan_id');
        //     $table->unsignedBigInteger('kbg_id');
        //     $table->text('alamat');
        //     $table->foreign('id_kepala_keluarga')->references('id')->on('users');
        //     $table->foreign('lingkungan_id')->references('id')->on('lingkungans');
        //     $table->foreign('kbg_id')->references('id')->on('kbgs');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluargas');
    }
}

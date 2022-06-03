<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomuniPertamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komuni_pertamas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_romo');
            $table->unsignedBigInteger('paroki_id');
            $table->dateTime('jadwal');
            $table->enum('status', ['Belum selesai', 'Selesai']);
            $table->string('file_sertifikat');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('id_romo')->references('id')->on('users');
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
        Schema::dropIfExists('komuni_pertamas');
    }
}

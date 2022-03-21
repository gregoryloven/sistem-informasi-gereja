<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaptissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baptiss', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('wali_baptis_ayah'); 
            $table->unsignedBigInteger('wali_baptis_ibu');
            $table->unsignedBigInteger('id_romo');
            $table->unsignedBigInteger('parokis_id');
            $table->string('nama_paroki');
            $table->string('jenis');
            $table->dateTime('jadwal');
            $table->enum('status', ['belum selesai', 'selesai']);
            $table->string('file_sertifikat');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('wali_baptis_ayah')->references('id')->on('users');
            $table->foreign('wali_baptis_ibu')->references('id')->on('users');
            $table->foreign('id_romo')->references('id')->on('users');
            $table->foreign('parokis_id')->references('id')->on('parokis');
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
        Schema::dropIfExists('baptiss');
    }
}

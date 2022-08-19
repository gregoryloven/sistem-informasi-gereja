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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('wali_baptis_ayah'); 
            $table->unsignedBigInteger('wali_baptis_ibu');
            $table->enum('jenis', ['Bayi', 'Dewasa']);
            $table->dateTime('jadwal');
            $table->string('lokasi');
            $table->string('romo');
            $table->enum('status', ['Diproses', 'Selesai']);
            $table->string('alasan_penolakan')->nullable();
            $table->string('file_sertifikat');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wali_baptis_ayah')->references('id')->on('users');
            $table->foreign('wali_baptis_ibu')->references('id')->on('users');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranPetugasLiturgisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_petugas_liturgis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_petugas_liturgi');
            $table->string('nama_lengkap');
            $table->string('lingkungan');
            $table->string('kbg');
            $table->datetime('jadwal');
            $table->string('lokasi');
            $table->enum('status', ['Diproses','Disetujui Paroki','Ditolak','Dibatalkan','Selesai']);
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('pendaftaran_petugas_liturgis');
    }
}

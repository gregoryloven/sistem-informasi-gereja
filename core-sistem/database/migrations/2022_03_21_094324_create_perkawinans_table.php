<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerkawinansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkawinans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_calon_suami');
            $table->unsignedBigInteger('id_calon_istri');
            $table->unsignedBigInteger('id_romo');
            $table->string('tempat_kpp');
            $table->date('tanggal_kpp');
            $table->date('tanggal_kononik');
            $table->string('tempat_perkawinan');
            $table->string('tanggal_perkawinan');
            $table->string('ttd_calon_suami');
            $table->string('ttd_calon_istri');
            $table->string('surat_liber_suami');
            $table->string('surat_liber_istri');
            $table->string('foto_berdampingan');
            $table->string('file_sertifikat_kpp');
            $table->string('file_sertifikat_perkawinan');
            $table->string('surat_pengantar_lingkungan');
            $table->foreign('id_calon_suami')->references('id')->on('users');
            $table->foreign('id_calon_istri')->references('id')->on('users');
            $table->foreign('id_romo')->references('id')->on('users');
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
        Schema::dropIfExists('perkawinans');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_lengkap_calon_suami');
            $table->string('tempat_lahir_calon_suami');
            $table->date('tanggal_lahir_calon_suami');
            $table->string('telepon_calon_suami');
            $table->string('nama_ayah_calon_suami');
            $table->string('alamat_calon_suami');
            $table->string('ktp_calon_suami');
            $table->string('suratpengantar_lingkungan_calon_suami')->nullable();
            $table->string('suratpengantar_paroki_calon_suami')->nullable();
            $table->string('nama_lengkap_calon_istri');
            $table->string('tempat_lahir_calon_istri');
            $table->date('tanggal_lahir_calon_istri');
            $table->string('telepon_calon_istri');
            $table->string('nama_ayah_calon_istri');
            $table->string('alamat_calon_istri');
            $table->string('ktp_calon_istri');
            $table->string('suratpengantar_lingkungan_calon_istri')->nullable();
            $table->string('suratpengantar_paroki_calon_istri')->nullable();
            $table->string('keterangan_kursus');
            $table->string('lokasi');
            $table->string('status');
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
        Schema::dropIfExists('kpps');
    }
}

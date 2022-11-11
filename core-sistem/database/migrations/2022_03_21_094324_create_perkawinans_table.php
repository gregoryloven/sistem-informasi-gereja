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
            $table->unsignedBigInteger('user_id');
            $table->string('nama_lengkap_calon_suami');
            $table->string('tempat_lahir_calon_suami');
            $table->date('tanggal_lahir_calon_suami');
            $table->string('pekerjaan_calon_suami');
            $table->string('alamat_calon_suami');
            $table->string('telepon_calon_suami');
            $table->string('agama_calon_suami');
            $table->string('paroki_calon_suami')->nullable();
            $table->string('nama_ayah_calon_suami');
            $table->string('agama_ayah_calon_suami');
            $table->string('pekerjaan_ayah_calon_suami');
            $table->string('nama_ibu_calon_suami');
            $table->string('agama_ibu_calon_suami');
            $table->string('alamat_orangtua_calon_suami');
            $table->string('surat_baptis_calon_suami')->nullable();
            $table->string('sertifikat_komuni_calon_suami')->nullable();
            $table->string('sertifikat_krisma_calon_suami')->nullable();
            $table->string('suratpengantar_lingkungan_calon_suami')->nullable();
            $table->string('suratpengantar_paroki_calon_suami')->nullable();
            $table->string('suratketerangan_bebas_menikah_calon_suami')->nullable();
            $table->string('suratpernyataan_nonkatolik_calon_suami')->nullable();
            $table->string('ktp_calon_suami');
            $table->string('kk_calon_suami');
            $table->string('ttd_calon_suami');
            $table->string('nama_lengkap_calon_istri');
            $table->string('tempat_lahir_calon_istri');
            $table->date('tanggal_lahir_calon_istri');
            $table->string('pekerjaan_calon_istri');
            $table->string('alamat_calon_istri');
            $table->string('telepon_calon_istri');
            $table->string('agama_calon_istri');
            $table->string('paroki_calon_istri')->nullable();
            $table->string('nama_ayah_calon_istri');
            $table->string('agama_ayah_calon_istri');
            $table->string('pekerjaan_ayah_calon_istri');
            $table->string('nama_ibu_calon_istri');
            $table->string('agama_ibu_calon_istri');
            $table->string('alamat_orangtua_calon_istri');
            $table->string('surat_baptis_calon_istri')->nullable();
            $table->string('sertifikat_komuni_calon_istri')->nullable();
            $table->string('sertifikat_krisma_calon_istri')->nullable();
            $table->string('suratpengantar_lingkungan_calon_istri')->nullable();
            $table->string('suratpengantar_paroki_calon_istri')->nullable();
            $table->string('suratketerangan_bebas_menikah_calon_istri')->nullable();
            $table->string('suratpernyataan_nonkatolik_calon_istri')->nullable();
            $table->string('ktp_calon_istri');
            $table->string('kk_calon_istri');
            $table->string('ttd_calon_istri');
            $table->string('sertifikat_kpp');
            $table->string('foto_berdampingan');
            $table->string('ktp_saksi_nikah');
            $table->date('tanggal_kanonik');
            $table->string('tempat_perkawinan');
            $table->datetime('tanggal_perkawinan');
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
        Schema::dropIfExists('perkawinans');
    }
}

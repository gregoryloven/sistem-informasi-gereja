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
            $table->integer('user_id_penerima');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('orangtua_ayah');
            $table->string('orangtua_ibu');
            $table->string('wali_baptis_ayah');
            $table->string('wali_baptis_ibu');
            $table->string('lingkungan');
            $table->string('kbg');
            $table->string('telepon');
            $table->enum('jenis', ['Baptis Bayi', 'Baptis Dewasa']);
            $table->dateTime('jadwal');
            $table->string('lokasi');
            $table->string('romo');
            $table->enum('status', ['Diproses','Disetujui KBG','Disetujui Lingkungan','Disetujui Paroki','Ditolak','Dibatalkan','Selesai']);
            $table->string('akta_kelahiran')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('surat_pernyataan')->nullable();
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
        Schema::dropIfExists('baptiss');
    }
}

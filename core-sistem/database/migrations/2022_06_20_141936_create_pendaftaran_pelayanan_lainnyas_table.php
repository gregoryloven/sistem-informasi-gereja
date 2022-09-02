<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranPelayananLainnyasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_pelayanan_lainnyas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pelayanan_lainnya_id');
            $table->string('nama_lengkap');
            $table->string('lingkungan');
            $table->string('kbg');
            $table->dateTime('jadwal');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Diproses','Disetujui KBG','Disetujui Lingkungan','Disetujui Paroki','Ditolak','Dibatalkan','Selesai']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pelayanan_lainnya_id')->references('id')->on('pelayanan_lainnyas');
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
        Schema::dropIfExists('pendaftaran_pelayanan_lainnyas');
    }
}

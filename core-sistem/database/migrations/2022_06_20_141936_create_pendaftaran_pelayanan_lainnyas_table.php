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
            $table->unsignedBigInteger('pelayanan_lainnya_id');
            $table->string('nama_pemohon');
            $table->dateTime('jadwal');
            $table->text('alamat');
            $table->text('keterangan')->nullable();
            $table->string('status');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrismasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krismas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('orangtua_ayah');
            $table->string('orangtua_ibu');
            $table->string('lingkungan');
            $table->string('kbg');
            $table->string('telepon');
            $table->dateTime('jadwal');
            $table->string('lokasi');
            $table->string('romo');
            $table->string('surat_baptis');
            $table->string('sertifikat_komuni');
            $table->enum('status', ['Diproses','Disetujui KBG','Disetujui Lingkungan','Disetujui Paroki','Ditolak','Dibatalkan','Selesai']);
            $table->string('sertifikat_krisma')->nullable();
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
        Schema::dropIfExists('krismas');
    }
}

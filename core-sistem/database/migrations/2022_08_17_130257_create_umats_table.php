<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('umats', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->string('nama_lengkap');
        //     $table->string('hubungan');
        //     $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
        //     $table->unsignedBigInteger('lingkungan_id');
        //     $table->unsignedBigInteger('kbg_id');
        //     $table->string('alamat');
        //     $table->string('telepon');
        //     $table->string('status');
        //     $table->string('foto_ktp')->nullable();
        //     $table->string('no_kk');
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->foreign('lingkungan_id')->references('id')->on('lingkungans');
        //     $table->foreign('kbg_id')->references('id')->on('kbgs');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umats');
    }
}

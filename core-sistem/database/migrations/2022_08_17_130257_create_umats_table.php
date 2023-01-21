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
        Schema::create('umats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_lengkap')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->unsignedBigInteger('lingkungan_id')->nullable();
            $table->unsignedBigInteger('kbg_id')->nullable();
            $table->string('status_baptis')->nullable();
            $table->string('surat_baptis')->nullable();
            $table->string('status_komuni')->nullable();
            $table->string('sertifikat_komuni')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lingkungan_id')->references('id')->on('lingkungans');
            $table->foreign('kbg_id')->references('id')->on('kbgs');
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
        Schema::dropIfExists('umats');
    }
}

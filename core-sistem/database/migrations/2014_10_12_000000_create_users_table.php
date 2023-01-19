<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            // $table->enum('agama', ['Katolik', 'Kristen', 'Islam', 'Hindu', 'Buddha', 'Khonghucu'])->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('role', ['admin', 'umat', 'ketua lingkungan', 'ketua kbg'])->nullable()->default('umat');
            $table->enum('status', ['Belum Tervalidasi', 'Tervalidasi', 'Ditolak', 'Dibatalkan'])->nullable();
            $table->string('status_baptis')->nullable();
            $table->string('surat_baptis')->nullable();
            $table->string('status_komuni')->nullable();
            $table->string('sertifikat_komuni')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};

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
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Katolik', 'Kristen', 'Islam', 'Hindu', 'Buddha', 'Khonghucu']);
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->string('telepon');
            $table->enum('role', ['admin', 'umat', 'romo', 'ketua lingkungan', 'ketua kbg']);
            $table->string('file_akta_kelahiran')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('username');
            $table->string('email');
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

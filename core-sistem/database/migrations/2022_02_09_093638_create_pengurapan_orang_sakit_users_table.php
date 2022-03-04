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
        Schema::create('pengurapan_orang_sakit_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('pengurapan_orang_sakits_id');
            $table->string('status');
            $table->string('role_pengurapan_orang_sakit');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('pengurapan_orang_sakits_id')->references('id')->on('pengurapan_orang_sakits');
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
        Schema::dropIfExists('pengurapan_sakit_users');
    }
};

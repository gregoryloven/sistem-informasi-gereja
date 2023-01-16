<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('list_event_id')->nullable();
            $table->integer('event_id');
            $table->string('jenis_event');
            $table->string('status');
            $table->string('kursus')->nullable();
            $table->string('alasan_pembatalan')->nullable();
            $table->string('alasan_penolakan')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('list_event_id')->references('id')->on('list_events');
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
        Schema::dropIfExists('riwayats');
    }
}

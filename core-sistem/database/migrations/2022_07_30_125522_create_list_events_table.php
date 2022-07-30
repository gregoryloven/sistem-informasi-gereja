<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->enum('jenis_event', ['Baptis', 'Komuni Pertama', 'Krisma', 'Tobat', 'Misa']);
            $table->datetime('jadwal');
            $table->string('lokasi');
            $table->string('romo');
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
        Schema::dropIfExists('list_events');
    }
}

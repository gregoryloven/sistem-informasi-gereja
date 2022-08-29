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
            $table->enum('jenis_event', ['Baptis Bayi', 'Baptis Dewasa', 'Komuni Pertama', 'Krisma', 'Tobat', 'Misa']);
            $table->date('tgl_buka_pendaftaran');
            $table->date('tgl_tutup_pendaftaran');
            $table->datetime('jadwal_pelaksanaan');
            $table->string('lokasi');
            $table->string('romo');
            $table->string('kuota')->nullable();
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

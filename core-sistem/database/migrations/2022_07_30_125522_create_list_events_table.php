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
            $table->unsignedBigInteger('petugas_liturgi_id')->nullable();
            $table->string('nama_event');
            $table->enum('jenis_event', ['Baptis Bayi', 'Baptis Dewasa', 'Komuni Pertama', 'Krisma', 'Tobat', 'Misa', 'Petugas Liturgi', 'Pelayanan', 'Pengurapan', 'Kursus Persiapan Perkawinan', 'Perkawinan']);
            $table->date('tgl_buka_pendaftaran')->nullable();
            $table->date('tgl_tutup_pendaftaran')->nullable();
            $table->datetime('jadwal_pelaksanaan')->nullable();
            $table->string('lokasi');
            $table->string('keterangan_kursus')->nullable();
            $table->string('romo')->nullable();
            $table->string('kuota')->nullable();
            $table->string('status')->nullable();
            $table->foreign('petugas_liturgi_id')->references('id')->on('petugas_liturgis');
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

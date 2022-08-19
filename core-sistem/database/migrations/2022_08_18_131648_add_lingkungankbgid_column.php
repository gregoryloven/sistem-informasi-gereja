<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLingkungankbgidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('lingkungan_id')->after('role')->nullable();
            $table->unsignedBigInteger('kbg_id')->after('lingkungan_id')->nullable();
            $table->foreign('lingkungan_id')->references('id')->on('lingkungans');
            $table->foreign('kbg_id')->references('id')->on('kbgs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('lingkungan_id');
            $table->dropColumn('lingkungan_id'); 
            $table->dropForeign('kbg_id');
            $table->dropColumn('kbg_id'); 
        });
    }
}

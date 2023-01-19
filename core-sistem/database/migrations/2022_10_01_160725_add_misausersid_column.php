<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMisausersidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('misa_users', function (Blueprint $table) {
        //     $table->unsignedBigInteger('users_id')->first();
        //     $table->unsignedBigInteger('list_events_id')->after('users_id');
        //     $table->foreign('users_id')->references('id')->on('users');
        //     $table->foreign('list_events_id')->references('id')->on('list_events');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('misa_users', function (Blueprint $table) {
        //     $table->dropForeign('users_id');
        //     $table->dropColumn('users_id'); 
        //     $table->dropForeign('list_events_id');
        //     $table->dropColumn('list_events_id'); 
        // });
    }
}

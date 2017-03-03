<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DirectoryAccessRights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directories', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id']);
        });

        Schema::create('directories_accress_rights', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('directory_id')->unsigned();
            $table->foreign('directory_id')->references('id')->on('directories');
            $table->boolean('is_creator')->nullable();
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
        //
    }
}

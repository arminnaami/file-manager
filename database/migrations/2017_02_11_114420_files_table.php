<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('directory_id')->unsigned()->nullable();
            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('restrict');;
            $table->text('name');
            $table->string('private_name');
            $table->string('extension');
            $table->foreign('extension')->references('id')->on('extensions')->onDelete('restrict');
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
    }
}

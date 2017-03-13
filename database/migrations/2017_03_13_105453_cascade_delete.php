<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CascadeDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directories_accress_rights', function (Blueprint $table) {
             $table->dropForeign('directories_accress_rights_user_id_foreign');
             $table->dropForeign('directories_accress_rights_directory_id_foreign');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('directory_id')->references('id')->on('directories')->onDelete('cascade');
        });
        Schema::table('access_rights', function (Blueprint $table) {
             $table->dropForeign('access_rights_user_id_foreign');
             $table->dropForeign('access_rights_file_id_foreign');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
        Schema::table('files', function (Blueprint $table) {
             $table->dropForeign('files_directory_id_foreign');
             $table->foreign('directory_id')->references('id')->on('directories')->onDelete('cascade');
        });
        Schema::table('directories', function (Blueprint $table) {
             $table->dropForeign('directories_parent_id_foreign');
             $table->foreign('parent_id')->references('id')->on('directories')->onDelete('cascade');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function($table) {
			$table->increments('id');
            $table->string('code', 14);
			$table->string('name', 40);
			$table->string('description', 255);
			$table->timestamps();
		});

		Schema::table('users', function (Blueprint $table)
		{
			$table->integer('role_id')->unsigned()->references('id')->on('roles');			
		});
        Schema::table('users', function (Blueprint $table)
		{
            $sql = "
				update
					users
				set 
					role_id = 2
				where 
					1 = 1
			";
			DB::connection()->getPdo()->exec($sql);
			
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

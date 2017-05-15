<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserProfileImage extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table)
		{
			$table->dropForeign('users_profile_picture_id_foreign');
			$table->string('profile_picture', 255)->nullable();
			
		});
		Schema::table('users', function (Blueprint $table)
		{
			$sql = "
				update
					users,
					files
				set 
					profile_picture = if(files.id = 1, null, concat(files.private_name, '.', files.extension))
				where 
					users.profile_picture_id = files.id
			";
			DB::connection()->getPdo()->exec($sql);


			$table->dropColumn('profile_picture_id');
			
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

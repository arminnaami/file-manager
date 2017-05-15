<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        Role::create([
            'id'            => 1,
            'code'          => 'admin',
            'name'          => 'Administrator',
            'description'   => 'Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.'
        ]);
        Role::create([
            'id'            => 2,
            'code'          => 'user',
            'name'          => 'User',
            'description'   => 'A standard user that can upload and download files. No administrative features.'
        ]);
        User::create([
            'name'          => 'Administrator',
            'email'         => 'admin@filemanager.dev',
            'password'      => bcrypt('welcomeToFilemanager'),
            'role_id'       => 1
        ]);

    }
}

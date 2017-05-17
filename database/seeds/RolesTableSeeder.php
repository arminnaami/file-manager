<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id'          => 1,
            'code'        => 'ADMIN',
            'name'        => 'Administrator',
            'description' => 'Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.',
        ]);
        Role::create([
            'id'          => 2,
            'code'        => 'USER',
            'name'        => 'User',
            'description' => 'A standard user that can upload and download files. No administrative features.',
        ]);
        Role::create([
            'id'          => 3,
            'code'        => 'MANAGER',
            'name'        => 'Manager',
            'description' => 'Full access to change project settings',
        ]);

        User::create([
            'name'       => 'Administrator',
            'email'      => 'admin@filemanager.dev',
            'password'   => bcrypt('welcomeToFilemanager'),
            'role_id'    => 1,
            'package_id' => 3,
        ]);

    }
}

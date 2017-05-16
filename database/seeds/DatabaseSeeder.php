<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PackageSeeder::class);
        $this->call(ExtensionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}

<?php

use App\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'id'             => 1,
            'name'           => "Package Small",
            'code'           => 'P_SMALL',
            'max_inodes'     => 10,
            'max_file_size'  => 3,
            'max_disk_space' => 50,
        ]);
        Package::create([
            'id'             => 2,
            'name'           => "Package Medium",
            'code'           => 'P_MEDIUM',
            'max_inodes'     => 15,
            'max_file_size'  => 5,
            'max_disk_space' => 60,
        ]);
        Package::create([
            'id'             => 3,
            'name'           => "Package Big",
            'code'           => 'P_BIG',
            'max_inodes'     => 100,
            'max_file_size'  => 20,
            'max_disk_space' => 500,
        ]);
    }
}

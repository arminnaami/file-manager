<?php

use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = new \App\File();
        $file->name = 'profile_picture';
        $file->private_name = md5('profile_picture');
        $file->extension = 'png';
        $file->description = 'Default profile image';

        $file->save();
    }
}

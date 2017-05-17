<?php

use Illuminate\Database\Seeder;

class ExtensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(DB::raw("insert into extensions values('fla-1', '#fla-1', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('dwg', '#dwg', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('dbf', '#dbf', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('rtf', '#rtf', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('file', '#file', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('exe', '#exe', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('search', '#search', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('csv', '#csv', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('json', '#json-file', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('raw', '#raw', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('aac', '#aac', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('dmg', '#dmg', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('fla', '#fla', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('midi', '#midi', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('3ds', '#3ds', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('dll', '#dll', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('dat', '#dat', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('ps', '#ps', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('indd', '#indd', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('flv', '#flv', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('cad', '#cad', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('eps', '#eps', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('mov', '#mov', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('tif', '#tif', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('bmp', '#bmp', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('mpg', '#mpg', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('wmv', '#wmv', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('cdr', '#cdr', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('iso', '#iso', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('sql', '#sql', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('gif', '#gif', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('html', '#html', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('css', '#css', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('js', '#js', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('ai', '#ai', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('psd', '#psd', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('mp3', '#mp3', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('svg', '#svg', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('avi', '#avi', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('xml', '#xml', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('txt', '#txt', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('php', '#php', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('zip', '#zip', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('png', '#png', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('jpg', '#jpg', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('ppt', '#ppt', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('xls', '#xls', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('doc', '#doc', 0, now(), now());"));
        DB::unprepared(DB::raw("insert into extensions values('pdf', '#pdf', 0, now(), now());"));
    }
}

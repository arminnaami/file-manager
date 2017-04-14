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
        DB::unprepared(DB::raw("insert into extensions values('fla-1', '#fla-1');"));
        DB::unprepared(DB::raw("insert into extensions values('dwg', '#dwg');"));
        DB::unprepared(DB::raw("insert into extensions values('dbf', '#dbf');"));
        DB::unprepared(DB::raw("insert into extensions values('rtf', '#rtf');"));
        DB::unprepared(DB::raw("insert into extensions values('file', '#file');"));
        DB::unprepared(DB::raw("insert into extensions values('exe', '#exe');"));
        DB::unprepared(DB::raw("insert into extensions values('search', '#search');"));
        DB::unprepared(DB::raw("insert into extensions values('csv', '#csv');"));
        DB::unprepared(DB::raw("insert into extensions values('json', '#json-file');"));
        DB::unprepared(DB::raw("insert into extensions values('raw', '#raw');"));
        DB::unprepared(DB::raw("insert into extensions values('aac', '#aac');"));
        DB::unprepared(DB::raw("insert into extensions values('dmg', '#dmg');"));
        DB::unprepared(DB::raw("insert into extensions values('fla', '#fla');"));
        DB::unprepared(DB::raw("insert into extensions values('midi', '#midi');"));
        DB::unprepared(DB::raw("insert into extensions values('3ds', '#3ds');"));
        DB::unprepared(DB::raw("insert into extensions values('dll', '#dll');"));
        DB::unprepared(DB::raw("insert into extensions values('dat', '#dat');"));
        DB::unprepared(DB::raw("insert into extensions values('ps', '#ps');"));
        DB::unprepared(DB::raw("insert into extensions values('indd', '#indd');"));
        DB::unprepared(DB::raw("insert into extensions values('flv', '#flv');"));
        DB::unprepared(DB::raw("insert into extensions values('cad', '#cad');"));
        DB::unprepared(DB::raw("insert into extensions values('eps', '#eps');"));
        DB::unprepared(DB::raw("insert into extensions values('mov', '#mov');"));
        DB::unprepared(DB::raw("insert into extensions values('tif', '#tif');"));
        DB::unprepared(DB::raw("insert into extensions values('bmp', '#bmp');"));
        DB::unprepared(DB::raw("insert into extensions values('mpg', '#mpg');"));
        DB::unprepared(DB::raw("insert into extensions values('wmv', '#wmv');"));
        DB::unprepared(DB::raw("insert into extensions values('cdr', '#cdr');"));
        DB::unprepared(DB::raw("insert into extensions values('iso', '#iso');"));
        DB::unprepared(DB::raw("insert into extensions values('sql', '#sql');"));
        DB::unprepared(DB::raw("insert into extensions values('gif', '#gif');"));
        DB::unprepared(DB::raw("insert into extensions values('html', '#html');"));
        DB::unprepared(DB::raw("insert into extensions values('css', '#css');"));
        DB::unprepared(DB::raw("insert into extensions values('js', '#js');"));
        DB::unprepared(DB::raw("insert into extensions values('ai', '#ai');"));
        DB::unprepared(DB::raw("insert into extensions values('psd', '#psd');"));
        DB::unprepared(DB::raw("insert into extensions values('mp3', '#mp3');"));
        DB::unprepared(DB::raw("insert into extensions values('svg', '#svg');"));
        DB::unprepared(DB::raw("insert into extensions values('avi', '#avi');"));
        DB::unprepared(DB::raw("insert into extensions values('xml', '#xml');"));
        DB::unprepared(DB::raw("insert into extensions values('txt', '#txt');"));
        DB::unprepared(DB::raw("insert into extensions values('php', '#php');"));
        DB::unprepared(DB::raw("insert into extensions values('zip', '#zip');"));
        DB::unprepared(DB::raw("insert into extensions values('png', '#png');"));
        DB::unprepared(DB::raw("insert into extensions values('jpg', '#jpg');"));
        DB::unprepared(DB::raw("insert into extensions values('ppt', '#ppt');"));
        DB::unprepared(DB::raw("insert into extensions values('xls', '#xls');"));
        DB::unprepared(DB::raw("insert into extensions values('doc', '#doc');"));
        DB::unprepared(DB::raw("insert into extensions values('pdf', '#pdf');"));
    }
}

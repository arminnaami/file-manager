<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DirectoryCls extends Facade{
    protected static function getFacadeAccessor() { return 'DirectoryCls'; }
}
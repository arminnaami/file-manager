<?php
namespace App\Classes;

use App\Directory;
use Storage;

class DirectoryCls {

    public static function GetParentsTree(Directory $directory, Array &$parents = array()){
        $parent = $directory->parent;
        if(!empty($parent)){
            $parents[] = $parent;
            self::GetParentsTree($parent, $parents);
        }
        return array_reverse($parents);
    }


    public static function CreateDirectory(Directory $directory){

    	$parents = self::GetParentsTree($directory);

    	$path = $directory->user_id;
    	foreach($parents as $parent){
    		$path .="/{$parent->name}/";
    	}
    	$path = $path.$directory->name;

    	Storage::makeDirectory($path);

    	$directory->save();
    }
}
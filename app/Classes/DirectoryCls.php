<?php
namespace App\Classes;

use App\Directory;
use Storage;
use Illuminate\Support\Facades\Auth;
class DirectoryCls {

    public static function GetParentsTree(Directory $directory, Array &$parents = array()){
        $parent = $directory->parent;
        if(!empty($parent)){
            $parents[] = $parent;
            self::GetParentsTree($parent, $parents);
        }
        return array_reverse($parents);
    }

    public static function GetDirectoryFullPath(Directory $directory){
        $user = Auth::user();

        $parents = self::GetParentsTree($directory);
        
        $path = $user->id;
        if(count($parents) > 0){
            $path = $parents[0]->users()->where('is_creator', true)->get()[0]->id;
        }
        $path .= '/';
        foreach($parents as $parent){
            $path .="{$parent->name}/";
        }
        $path = $path.$directory->name;
        return $path;
    }
    public static function CreateDirectory(Directory $directory){
        $user = Auth::user();
        $path = self::GetDirectoryFullPath($directory);
    	Storage::makeDirectory($path);

    	$directory->save();
        $user->directories()->attach($directory->id, ['is_creator' => true]); 
    }

    public static function DeleteDirectory(Directory $directory){
        $user = Auth::user();
        $deleteFolder = false;
        if(count($directory->users) == 1){
            $deleteFolder = true;
        }

        $directory->users()->detach($user->id);

        if($deleteFolder){
            $path = self::GetDirectoryFullPath($directory);
            Storage::deleteDirectory($path);
            $directory->delete();
        }
    }
}
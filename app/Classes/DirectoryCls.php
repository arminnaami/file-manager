<?php
namespace App\Classes;

use App\Directory;
use Storage;
use App\User;
class DirectoryCls {

    public static function GetParentsTree(Directory $directory = null, Array &$parents = array()){

        if(!$directory){
            return null;
        }

        $parent = $directory->parent;
        if(!empty($parent)){
            $parents[] = $parent;
            self::GetParentsTree($parent, $parents);
        }
        return array_reverse($parents);
    }

    public static function GetDirectoryFullPath(Directory $directory, User $user){

        $parents = self::GetParentsTree($directory);

        $path = '/'.$user->id;

        if(!$parents){
            if($directory->name == ''){
                return $path.'/';
            }
            return $path.'/'.$directory->name.'/';
        }

        if(count($parents) > 0){
            $path = $parents[0]->users()->where('is_creator', true)->get()[0]->id;
        }
        $path .= '/';
        foreach($parents as $parent){
            $path .="{$parent->name}/";
        }
        $path = $path.$directory->name.'/';
        return $path;
    }
    public static function CreateDirectory(Directory $directory, User $user){

        $path = self::GetDirectoryFullPath($directory, $user);
    	Storage::makeDirectory($path);

    	$directory->save();
        $user->directories()->attach($directory->id, ['is_creator' => true]);
    }

    public static function DeleteDirectory(Directory $directory, User $user){
        if(!$directory->users()->find($user->id)->pivot->is_creator){
            $directory->users()->detach($user->id);
            return;
        }

        $path = self::GetDirectoryFullPath($directory, $user);
        Storage::deleteDirectory($path);
        $directory->delete();
    }
}
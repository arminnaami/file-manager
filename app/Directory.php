<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    protected $fillable = [
        'name', 'parent_id', 'original_name',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Directory', 'parent_id', 'id');
    }

    public function directories()
    {
        return $this->hasMany('App\Directory', 'parent_id', 'id');
    }
    public function files()
    {
        return $this->hasMany('App\Directory', 'directory_id', 'id');
    }

    public function getParents($directory, &$parents){
        $parent = $directory->parent;
        if(!empty($parent)){
            $parents[] = $parent;
            $this->getParents($parent, $parents);
        }
        return array_reverse($parents);
    }

    public function getFullPath($directory, &$path){
        $parent = $directory->parent;
        if(!empty($parent)){
            $path[] = $parent->name;
            $this->getFullPath($parent, $path);
        }
        dd($path);
        return array_reverse($parents);
    }
}

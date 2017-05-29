<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'original_name',
    ];

    /**
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo('App\Directory', 'parent_id', 'id');
    }

    /**
     * @return mixed
     */
    public function directories()
    {
        return $this->hasMany('App\Directory', 'parent_id', 'id');
    }
    /**
     * @return mixed
     */
    public function files()
    {
        return $this->hasMany('App\File', 'directory_id', 'id');
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'directories_accress_rights', 'directory_id', 'user_id')
            ->withPivot('created_at', 'is_creator')
            ->withTimestamps();
    }

    /**
     * @param $directory
     * @param array $parents
     */
    public function getParentsTree($directory = null, array &$parents = array())
    {
        if ($directory == null)
        {
            $directory = $this;
        }
        $parent = $directory->parent;
        if (!empty($parent))
        {
            $parents[] = $parent;
            $this->getParentsTree($parent, $parents);
        }
        return array_reverse($parents);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($directory)
        {
            $directory->files()->delete();
            $directory->directories()->delete();
        });
    }
}

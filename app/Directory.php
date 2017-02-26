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
        return $this->belongsTo('App\Directory', 'id', 'parent_id');
    }

    public function directories()
    {
        return $this->hasMany('App\Directory', 'parent_id', 'id');
    }
    public function files()
    {
        return $this->hasMany('App\Directory', 'directory_id', 'id');
    }
}

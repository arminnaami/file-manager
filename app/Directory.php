<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    protected $fillable = [
        'name', 'directory_id',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Directory', 'id', 'parent_id');
    }

    public function folders()
    {
        return $this->hasMany('App\Directory', 'parent_id', 'id');
    }
    public function files()
    {
        return $this->hasMany('App\Directory', 'directory_id', 'id');
    }
}

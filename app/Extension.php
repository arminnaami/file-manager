<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'icon_id',
    ];

    public function files()
    {
        return $this->hasMany('App\File', 'id', 'extension');
    }
}

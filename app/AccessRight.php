<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessRight extends Model
{
    protected $fillable = [
        'user_id', 'file_id', 'file_access_token',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function file()
    {
        return $this->hasOne('App\File', 'id', 'file_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'private_name', 'extension', 'description', 'is_crypted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function users()
    {
        return $this->belongsToMany('App\User', 'access_rights', 'file_id', 'user_id')
            ->withPivot('created_at', 'file_access_token', 'is_creator')
            ->withTimestamps();
    }
    public function extensionIcon()
    {
        return $this->hasOne('App\Extension', 'id', 'extension');
    }
}

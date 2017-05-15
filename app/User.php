<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function files()
    {
        return $this->belongsToMany('App\File', 'access_rights', 'user_id', 'file_id')
            ->withPivot('created_at', 'file_access_token')
            ->withTimestamps();
    }
    public function directories()
    {
        return $this->belongsToMany('App\Directory', 'directories_accress_rights', 'user_id', 'directory_id')
            ->withPivot('created_at', 'is_creator')
            ->withTimestamps();
    }
}

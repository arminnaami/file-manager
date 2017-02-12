<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'name', 'email', 'password', 'profile_picture_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profileImage(){
        return $this->hasOne('App\File', 'id', 'profile_picture_id');
    }

    public function files()
    {
        return $this->belongsToMany('App\File', 'access_rights', 'user_id', 'file_id')
                    ->withPivot('created_at', 'file_access_token')
                    ->withTimestamps();
    }
}

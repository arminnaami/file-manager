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

    public function getOwnedDirectories(){
        $dirs = $this->directories()->where('is_creator', true)->where('parent_id', null)->get();
        return $dirs;
    }

    public function getSharedWithMeDirectories(){
        $dirs = $this->directories()->where('is_creator', false)->where('is_root', true)->get();
        return $dirs;
    }

    public function getOwnedFiles(){
        $files = $this->files()->where('is_creator', true)->where('directory_id', null)->get();
        return $files;
    }


    public function getSharedWIthMeFiles(){
        $files = $this->files()->where('is_creator', false)->get();
        foreach($files as $k => $file){
            if($file->directory_id != null){
                $directory = $this->directories()->where('directory_id', $file->directory_id)->where('is_creator', false)->first();
                if($directory){
                    unset($files[$k]);
                    
                }
            }
        }
        return $files;
    }

    public function addFile(File $file, $isCreator = false){
        $hasAccess = $this->files()->where('file_id', $file->id)->first();
        if($hasAccess == null){
            $this->files()->attach($file->id, ['is_creator' => $isCreator]);
        }
    }

    public function removeFile(File $file){
        $this->files()->detach($file->id);
    }


    public function addDirectory(Directory $directory, $isRoot = true){
        
        $hasAccess = $this->directories()->where('directory_id', $directory->id)->first();
        if($hasAccess == null){
            $this->directories()->attach($directory->id, ['is_creator' => false, 'is_root' => $isRoot]);
        }else{
             $this->directories()->updateExistingPivot($directory->id, ['is_root' => $isRoot]);
        }
       
        $files = $directory->files;
        if(count($files) > 0){
            foreach($files as $file){
                $this->addFile($file);
            }
        }


        $directories = $directory->directories;
        if(count($directories) > 0){
            foreach($directories as $dir){
                $this->addDirectory($dir, false);
            }
        }
    }




    public function removeDirectory(Directory $directory){

        $this->directories()->detach($directory->id);
        $files = $directory->files;
        if(count($files) > 0){
            foreach($files as $file){
                $this->removeFile($file);
            }
        }


        $directories = $directory->directories;
        if(count($directories) > 0){
            foreach($directories as $dir){
                $this->removeDirectory($dir);
            }
        }
    }


    public function role()
	{
		return $this->hasOne('App\Role', 'id', 'role_id');
	}

    public function hasRole($roles)
	{
		$this->haveRole = $this->getUserRole();
		// Check if the user is a root account
		if($this->haveRole->code == 'admin') {
			return true;
		}
		if(is_array($roles)){
			foreach($roles as $need_role){
				if($this->checkIfUserHasRole($need_role)) {
					return true;
				}
			}
		} else{
			return $this->checkIfUserHasRole($roles);
		}
		return false;
	}
    private function getUserRole()
	{
		return $this->role()->getResults();
	}
    private function checkIfUserHasRole($need_role)
	{
		return (strtolower($need_role)==strtolower($this->haveRole->code)) ? true : false;
	}

    public function addRole(Role $role){
        $this->role_id = $role->id;
        $this->save();
    }
}

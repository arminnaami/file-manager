<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * @var string
     */
    protected $table = 'packages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'max_file_size', 'max_inodes', 'max_disk_space',
    ];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $hidden = ['id'];

    protected $with = ['replies'];
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}

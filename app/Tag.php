<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;

class Tag extends Model
{
    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']= Str::slug($value);
    }

    public function posts(){
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}

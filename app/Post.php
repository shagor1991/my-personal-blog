<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function categories(){
        return $this->belongsToMany('App\Category')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}

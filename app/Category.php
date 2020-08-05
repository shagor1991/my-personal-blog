<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;

class Category extends Model
{
    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['category_slug'] = Str::slug($value);
    }

    public function posts(){
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}

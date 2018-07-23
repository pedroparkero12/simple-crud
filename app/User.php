<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['id','username','firstname','lastname'];

    public function setFirstnameAttribute($value){
        $this->attributes['firstname'] = title_case($value);
    }

    public function setLastnameAttribute($value){
        $this->attributes['lastname'] = title_case($value);
    }
}




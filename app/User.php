<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['id','username','firstname','lastname'];

    protected $dates = ['deleted_at'];

    public function setFirstnameAttribute($value){
        $this->attributes['firstname'] = title_case($value);
    }

    public function setLastnameAttribute($value){
        $this->attributes['lastname'] = title_case($value);
    }
}




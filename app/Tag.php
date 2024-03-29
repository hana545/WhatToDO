<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function places(){
        return $this->belongsToMany(Place::class);
    }
}

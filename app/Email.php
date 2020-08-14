<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function places(){
        return $this->belongsTo(Place::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [ 'email', 'place_id' ];
    public function places(){
        return $this->belongsTo(Place::class);
    }
}

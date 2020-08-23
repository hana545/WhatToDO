<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [ 'url', 'place_id' ];
    public function places(){
        return $this->belongsTo(Place::class);
    }
}

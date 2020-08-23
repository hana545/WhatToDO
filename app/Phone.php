<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [ 'number', 'place_id' ];
    public function places(){
        return $this->belongsTo(Place::class);
    }
}

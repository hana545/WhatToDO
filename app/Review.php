<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Review extends Model
{
    protected $fillable = [
        'star', 'description'];


    public function place(){
        return $this->belongsTo(Place::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

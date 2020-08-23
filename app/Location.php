<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Location extends Model
{
    protected $fillable = [
        'name', 'address', 'lat', 'lng', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'name', 'search_name', 'address', 'lat', 'lng', 'description', 'category_id', 'user_id', 'approved'
    ];

    public function setSearchNameAttribute($value)
    {
        $this->attributes['search_name'] = strtolower($value);
    }

    public function getApprovedAttribute($attribute){
        return [
            0 => 'Not approved',
            1 => 'Approved'
        ][$attribute];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function phones() {
        return $this->hasMany(Phone::class);
    }
    public function emails() {
        return $this->hasMany(Email::class);
    }
    public function website() {
        return $this->hasMany(Website::class);
    }

    public function workhour() {
        return $this->hasOne(Workhour::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}

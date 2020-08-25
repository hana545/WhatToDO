<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Workhour extends Model
{
    protected $fillable = [
        'monday_start1', 'monday_end1', 'monday_start2', 'monday_end2',
        'tuesday_start1', 'tuesday_end1', 'tuesday_start2', 'tuesday_end2',
        'wednesday_start1', 'wednesday_end1', 'wednesday_start2', 'wednesday_end2',
        'thursday_start1', 'thursday_end1', 'thursday_start2', 'thursday_end2',
        'friday_start1', 'friday_end1', 'friday_start2', 'friday_end2',
        'saturday_start1', 'saturday_end1', 'saturday_start2', 'saturday_end2',
        'sunday_start1', 'sunday_end1', 'sunday_start2', 'sunday_end2',
        'place_id'
    ];

    protected $dates = ['monday_start1', 'monday_end1', 'monday_start2', 'monday_end2',
        'tuesday_start1', 'tuesday_end1', 'tuesday_start2', 'tuesday_end2',
        'wednesday_start1', 'wednesday_end1', 'wednesday_start2', 'wednesday_end2',
        'thursday_start1', 'thursday_end1', 'thursday_start2', 'thursday_end2',
        'friday_start1', 'friday_end1', 'friday_start2', 'friday_end2',
        'saturday_start1', 'saturday_end1', 'saturday_start2', 'saturday_end2',
        'sunday_start1', 'sunday_end1', 'sunday_start2', 'sunday_end2'];

    public function place() {
        return $this->belongsTo(Place::class);
    }
}

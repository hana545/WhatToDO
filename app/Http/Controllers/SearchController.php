<?php

namespace App\Http\Controllers;

use App\Place;
use App\Category;
use App\Tag;
use \App\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use function MongoDB\BSON\toJSON;

class SearchController extends Controller
{
    public function index(){

        $lat=session('lat');
        $lng=session('lng');
        session()->forget('lat');
        session()->forget('lng');

        $user = Auth::user();
        $places = Place::where('approved', '=', '1')->get();
        //dd($places, $place);
        $categories = Category::all();
        $tags = Tag::all();
        $range = 15;
        $rangeEnabled = 0;
        //dd(session('lat'));



        foreach ($places as $place) {
            if($lat && $lng){
                $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
            } else {
                $place->dist = 1;
            }
            $place->UserReview = new Review();
            $place->hasReview = false;
            if ($place->reviews->isNotEmpty()) {
                $count = 0;
                $sum = 0;
                foreach ($place->reviews as $review) {

                    if ($user) {
                        if ($review->user->id == $user->id) {
                            $place->hasReview = true;
                            $place->UserReview = $review;

                        }
                    }
                    $sum += $review->star;
                    $count++;


                }
                $place->avgStar = $sum / $count;
            } else {
                $place->avgStar = 0;
            }

            if ($place->workhour) {
                if(session('timezone')) date_default_timezone_set(session('timezone'));
                $t = time();
                $daystart1 = strtolower(date("l", $t)) . '_start1';
                $dayend1 = strtolower(date("l", $t)) . '_end1';
                $daystart2 = strtolower(date("l", $t)) . '_start2';
                $dayend2 = strtolower(date("l", $t)) . '_end2';
                $t = date("H:i", $t);

                $place->open = 0;

                if ($place->workhour->$daystart1 && $place->workhour->$dayend1) {
                    if ($place->workhour->$daystart1->format('H:i') <= $t && $place->workhour->$dayend1->format('H:i') >= $t) {
                        $place->open = 1;
                    }
                }
                if ($place->workhour->$daystart2 && $place->workhour->$dayend2) {
                    if ($place->workhour->$daystart2->format('H:i') <= $t && $place->workhour->$dayend2->format('H:i') >= $t) {
                        $place->open = 1;
                    }
                }
            } else {
                $place->open = 3;
            }
        }

        if(!$rangeEnabled) {
            $places = $places->where('dist', '<=', $range)->sortBy('dist');
        } else {
            $places = $places->sortBy('dist');
        }
        $find = true;
        if (empty($places->first())) {
            $find = false;
        }
        $randomPlace = null;
        $search_name = '';
        $categories_req = [];
        $tags_req = [];
        $random = false;
        $mysaveloc = false;
        $mysavelocname = 'My saved location';
        //dd($find, $lat, $lng, $places);
        //dd(gettype($lat));
        return view('search.index', compact('user','places', 'categories', 'tags', 'range', 'find', 'search_name', 'lat', 'lng', 'categories_req', 'tags_req', 'random', 'randomPlace', 'mysaveloc', 'mysavelocname'));
    }

    public function search(){
        //$response = Http::get('http://ip-api.com/json');
        //dd(request());
        //for search and remembering filter variables
        $categories = Category::all();
        $tags = Tag::all();
        $categories_req = request('category');
        $tags_req = request('tag');
        $random = request('random');


        $user = Auth::user();
        $places =  Place::where('approved', '=', '1');

        ///search by name
        $search_name = request('search_name');
        if($search_name) $places = $places->where('search_name', 'like', '%'.strtolower($search_name).'%');

        //search by categories

        if(!empty($categories_req)) {
            $places = $places->whereIn('category_id', $categories_req);
        }
        $places = $places->get();


        //search by range, pull unwanted tags, calculate review; sort by dist
        $range = request('range');
        $rangeEnabled = request('rangeEnabled');

        $lat=session('lat');
        $lng=session('lng');
        session()->forget('lat');
        session()->forget('lng');

        $mysaveloc = false;
        $mysavelocname = 'My saved location';
        if(request('location') != 1){
            $savedLocationString = request('savedLocation');
            $savedLocation = json_decode($savedLocationString, true);
            $mysaveloc = true;
            $mysavelocname = $savedLocation[0];
            $lat = $savedLocation[1];
            $lng =$savedLocation[2];
        }

        foreach ($places as $num => $place) {
            $flag = false;
            if (!empty($tags_req)) {
                foreach ($place->tags as $tag) {
                    if (in_array($tag->id, $tags_req)) {
                        $flag = true;
                    }
                }
                if (!$flag) {
                    $places->pull($num);
                    continue;
                }
            }
            if($lat && $lng)  {
                $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
            } else {
                $place->dist = 1;
            }

            $place->UserReview = new Review();
            $place->hasReview = false;
            if ($place->reviews->isNotEmpty()) {
                $count = 0;
                $sum = 0;
                foreach ($place->reviews as $review) {

                    if ($user) {
                        if ($review->user->id == $user->id) {
                            $place->hasReview = true;
                            $place->UserReview = $review;

                        }
                    }
                    $sum += $review->star;
                    $count++;


                }
                $place->avgStar = $sum / $count;
            } else {
                $place->avgStar = 0;
            }
            if ($place->workohour){
                if(session('timezone')) date_default_timezone_set(session('timezone'));
                $t = time();
                $daystart1 = strtolower(date("l", $t)) . '_start1';
                $dayend1 = strtolower(date("l", $t)) . '_end1';
                $daystart2 = strtolower(date("l", $t)) . '_start2';
                $dayend2 = strtolower(date("l", $t)) . '_end2';
                $t = date("H:i", $t);
                $place->open = false;
                if ($place->workhour->$daystart1 && $place->workhour->$dayend1) {
                    if ($place->workhour->$daystart1->format('H:i') <= $t && $place->workhour->$dayend1 >= $t) {
                        $place->open = true;
                    }
                } else if ($place->workhour->$daystart2 && $place->workhour->$dayend2) {
                    if ($place->workhour->$daystart2->format('H:i') <= $t && $place->workhour->$dayend2 >= $t) {
                        $place->open = true;
                    }
                }
            } else {
            $place->open = true;
            }
        }
        if(!$rangeEnabled) {
            $places = $places->where('dist', '<=', $range)->sortBy('dist');
        } else {
            $places = $places->sortBy('dist');
        }
        //if ($places->first()) $center = [$places->first()->lat, $places->first()->lng];

        //randomPick
        $randomPlace = null;
        if($random && $places->isNotEmpty()) $randomPlace = $places->random();

        //if no matching places were found
        $find = true;
        if (empty($places->first())) {
            $find = false;
        }


        return view('search.index', compact('user','places', 'categories', 'tags', 'range', 'find', 'search_name', 'lat', 'lng', 'categories_req', 'tags_req', 'random', 'randomPlace', 'mysaveloc', 'mysavelocname'));
    }

    public function getDistance(float $lat1, float $lng1, float $lat2, float $lng2){
        $r = 6371;
        $dlat = deg2rad($lat2-$lat1);
        $dlng = deg2rad($lng2-$lng1);

        $a = sin($dlat/2) * sin($dlat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dlng/2) * sin($dlng/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $r * $c;

        return $d;
    }

    public function getCoordinates(Request $request)
    {
        session(['lat' => $request->latitude]);
        session(['lng' => $request->longitude]);

    }

    public function getTimezone(Request $request)
    {
        session(['timezone' => $request->timezone]);


    }

}

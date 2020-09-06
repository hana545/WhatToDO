<?php

namespace App\Http\Controllers;
use App\Place;
use App\Category;
use App\Tag;
use \App\Review;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\Location;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function search(){

        $lat=session('lat');
        $lng=session('lng');
        session()->forget('lat');
        session()->forget('lng');

        $user = Auth::user();

        //get all approved places
        $places = Place::where('approved', '=', '1')->get();

        $categories = Category::all()->sortBy('name');
        $tags = Tag::all()->sortBy('name');

        //default
        $range = 10;
        $rangeEnabled = 0;

        //for each place, calculate distance, avg review and is it opened or closed
        foreach ($places as $place) {

            //calculate distance, if location unknown, dist = 1
            if($lat && $lng){
                $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
            } else {
                $place->dist = 1;
            }

            //if place have any reviews, calculate avg star
            self::avg_star($place);

            //if place have workhours, see is it opened or closed
            self::check_workhour($place);
        }

        ///if there is range, take places under default range
        if(!$rangeEnabled) {
            $places = $places->where('dist', '<=', $range)->sortBy('dist');
        } else {
            $places = $places->sortBy('dist');
        }
        //if there are any places, find is false
        $find = true;
        if (empty($places->first())) {
            $find = false;
        }
        // null values needed for searchFilter
        $random = false;
        $randomPlace = null;
        $search_name = '';
        $categories_req = [];
        $tags_req = [];
        $mysaveloc = false;

        return view('search.index', compact('user','places', 'categories', 'tags', 'range', 'find',
            'search_name', 'lat', 'lng', 'categories_req', 'tags_req', 'random', 'randomPlace', 'mysaveloc'));
    }

    public function searchFilter(){

        //for general search
        $categories = Category::all()->sortBy('name');
        $tags = Tag::all()->sortBy('name');
        //for  remembering filter variables
        $categories_req = request('category');
        $tags_req = request('tag');
        $random = request('random');


        $user = Auth::user();
        //all approved places
        $places =  Place::where('approved', '=', '1');

        ///search by name
        $search_name = request('search_name');
        if($search_name) $places = $places->where('search_name', 'like', '%'.strtolower($search_name).'%');

        //search by categories
        if(!empty($categories_req)) {
            $places = $places->whereIn('category_id', $categories_req);
        }
        $places = $places->get();


        //search by range, take range
        $range = request('range');
        $rangeEnabled = request('rangeEnabled');

        //take users lat and lng
        $lat=session('lat');
        $lng=session('lng');
        session()->forget('lat');
        session()->forget('lng');

        //if enabled search around saved location, take locations lat, lng
        $mysaveloc = false;
        $mysavelocname = 'My saved location';
        if(request('location') != 1){
            if (!request('savedLocation')) return redirect('/search')->with('error', 'Choose your saved location');
            $savedLocationString = request('savedLocation');
            $savedLocation = json_decode($savedLocationString, true);
            $mysaveloc = true;
            $mysavelocname = $savedLocation[0];
            $lat = $savedLocation[1];
            $lng =$savedLocation[2];
        }
        //pull places with unwanted tags, calculate review; sort by dist
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
            //calculate distance
            if($lat && $lng)  {
                $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
            } else {
                $place->dist = 1;
            }
            //calculate review
            self::avg_star($place);
            //if place has workhour, see is it opened or closed
            self::check_workhour($place);
        }

        ///if there is range, take places under default range
        if(!$rangeEnabled) {
            $places = $places->where('dist', '<=', $range)->sortBy('dist');
        } else {
            $places = $places->sortBy('dist');
        }

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

    public function avg_star(Place $place){
        $user = Auth::user();
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
    }
    public function check_workhour (Place $place){

        if ($place->workhour){
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
            } else if ($place->workhour->$daystart2 && $place->workhour->$dayend2) {
                if ($place->workhour->$daystart2->format('H:i') <= $t && $place->workhour->$dayend2->format('H:i') >= $t) {
                    $place->open = 1;
                }
            }
        } else {
            $place->open = 3;
        }
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

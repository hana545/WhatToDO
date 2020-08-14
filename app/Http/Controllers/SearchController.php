<?php

namespace App\Http\Controllers;

use App\Place;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class SearchController extends Controller
{
    public function index(){
        $places = Place::where('approved', '=', '1')->get();
        //dd($places, $place);
        $categories = Category::all();
        $tags = Tag::all();
        $range = 15;
        //dd(session('lat'));
        $lat=session('lat');
        $lng=session('lng');
        foreach ($places as $place) {
            $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
        };

        $places = $places->where('dist', '<=', $range)->sortBy('dist');
        //dd(session('lat'));
        //

        $find = true;
        //dd(gettype($lat));
        return view('search.index', compact('places', 'categories', 'tags', 'range', 'find', 'lat', 'lng'));
    }

    public function search(){
        //dd(request());
        $places =  Place::where('approved', '=', '1');

        ///search by name
        if(request('search_name')) $places = $places->where('search_name', 'like', strtolower(request('search_name')).'%');

        //search by categories
        $categories_req = request('category');
        if(!empty($categories_req)) {
            $places = $places->whereIn('category_id', $categories_req);
        }

        //search by tags
        /*
        $tags_req = request('tag');
        if(!empty($tags_req)) {
            $places = $places->whereIn('tag_id', $tags_req);
        }
        */
        $places = $places->get();

        //search by range; sort by dist
        $range = request('range');
        $lat=session('lat');
        $lng=session('lng');
        foreach ($places as $place) {
            $place->dist = $this->getDistance($lat, $lng, $place->lat, $place->lng);
        };
        $places = $places->where('dist', '<=', $range)->sortBy('dist');
        //if ($places->first()) $center = [$places->first()->lat, $places->first()->lng];


        //if no matching places were found
        $find = false;
        if (!empty($places->first())) {
            $find = true;
        } else {
        }
        //for search
        $categories = Category::all();
        $tags = Tag::all();

        return view('search.index', compact('places', 'categories', 'tags', 'range', 'find', 'lat', 'lng'));
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
}

<?php

namespace App\Http\Controllers;
use \App\Tag;
use \App\Category;
use \App\Place;
use \App\Phone;
use \App\Email;
use \App\Website;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlacesController extends Controller
{

    public function index(){

    }

    public function create(){
        $days = ['Monday', 'Tuesday', 'Wendseday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $categories = Category::all();
        $tags = Tag::all();
        return view('places.create', compact('days','categories', 'tags'));
    }
    public function store(){
        $user = Auth::user();

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'lat' => 'numeric',
            'lng' => 'numeric',
            'description' => 'required|min:10|max:255',
            'picture' => 'sometimes|file|image|max:4000',
            'phone1' => 'required|min:3|numeric',
            'email1' => 'required|min:3|email',
            'website1' => 'required|min:3|url',
            'phone2' => 'min:3|numeric',
            'email2' => 'min:3|email',
            'website2' => 'min:3|url',
            'category' => 'required',
        ]);
      //  dd($data);
        /*
        $other = request()->validate([
            'description' => 'required|min:5',
            'phone1' => 'required|min:3|numeric',
            'email1' => 'required|min:3|email',
            'website1' => 'required|min:3|url',
            'phone1' => 'min:3|numeric',
            'email1' => 'min:3|email',
            'website1' => 'min:3|url',
            'category' => 'required',
        ]);*/
        $place = new Place();
        $place->name = $data['name'];
        $place->search_name = $data['name'];
        $place->address = $data['address'];
        $place->lat = $data['lat'];
        $place->lng = $data['lng'];
        $place->description = $data['description'];
        $place->category_id = $data['category'];
        $place->user_id = $user->id;
        $place->approved = false;
        $place->save();

        $phone = new Phone();
        $phone->number = $data['phone1'];
        $phone->place_id = $place->id;
        $phone->save();
        if (array_key_exists('phone2', $data)){
            $phone = new Phone();
            $phone->number = $data['phone2'];
            $phone->place_id = $place->id;
            $phone->save();
        }

        $email = new Email();
        $email->email = $data['email1'];
        $email->place_id = $place->id;
        $email->save();
        if (array_key_exists('email2', $data)){
            $email = new Email();
            $email->email = $data['email2'];
            $email->place_id = $place->id;
            $email->save();
        }

        $website = new Website();
        $website->url = $data['website1'];
        $website->place_id = $place->id;
        $website->save();
        if (array_key_exists('website2', $data)){
            $website = new Email();
            $website->url = $data['website2'];
            $website->place_id = $place->id;
            $website->save();
        }
        return redirect('/search');

    }

    public function approve(){
        $places = Place::where('approved', false)->get();
      //  dd($places->first());
        return view('places.approve', compact('places'));
    }

    public function approving(Place $place){
        $place->approved = true;
        $place->save();
        return redirect('/approve')->with('message', 'You have approved '. $place->name);
    }
}

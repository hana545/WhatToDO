<?php

namespace App\Http\Controllers;
use \App\Tag;
use \App\Category;
use \App\Place;
use \App\Phone;
use \App\Email;
use \App\Website;
use \App\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Geocoder\Facades\Geocoder;
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

        $place= new Place;
        $update=false;
        return view('places.create', compact('days','categories', 'tags', 'update', 'place'));
    }
    public function store(){
        $user = Auth::user();

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'description' => 'required|min:10|max:255',
            'phone1' => 'nullable|min:3|phone',
            'email1' => 'nullable|min:3|max:40|email',
            'website1' => 'nullable|min:3|max:70|url',
            'phone2' => 'nullable|numeric|phone',
            'email2' => 'nullable|min:3|max:40|email',
            'website2' => 'nullable|min:3|max:70|url',
            'category' => 'required',
            'multiple_images.*' => 'sometimes|file|image|max:8000',
        ]);
        $address = $data['address'];
        $address = str_replace(" ","+", $address);
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyAY9df1pMrDrLQ7JcEFuBZh0CdtpUFMdAY');
        $latlng = $response->json()['results'][0]['geometry']['location'];
        $lat = $latlng['lat'];
        $lng = $latlng['lng'];
        $place = Place::create([
            'name' =>  $data['name'],
            'search_name' =>  $data['name'],
            'address' =>  $data['address'],
            'lat' =>  $lat,
            'lng' =>  $lng,
            'description' =>  $data['description'],
            'category_id' =>  $data['category'],
            'user_id' =>  $user->id,
            'approved' =>  false,
        ]);

        if(request()->has('multiple_images')) {
            // dd('uco');
            foreach($data['multiple_images'] as $img) {

                $img_name = $img->store('uploads', 'public');
                $img_data[] = $img_name;
            }


            $place->images = json_encode($img_data);
            $place->save();
           // dd( $place->images);
        }
       // $place->save();

        if(!is_null($data['phone1'])) {
            $phone1 = Phone::create([
                'number' =>  $data['phone1'],
                'place_id' =>  $place->id,
            ]);
        }
        if(!is_null($data['phone2'])){
            $phone2 = Phone::create([
                'number' =>  $data['phone2'],
                'place_id' =>  $place->id,
            ]);
        }
        if(!is_null($data['email1'])) {
            $email1 = Email::create([
                'email' =>  $data['email1'],
                'place_id' =>  $place->id,
            ]);
        }
        if(!is_null($data['email2'])){
            $email2 = Email::create([
                'email' =>  $data['email2'],
                'place_id' =>  $place->id,
            ]);
        }

        if(!is_null($data['website1'])) {
            $website1 = Website::create([
                'url' =>  $data['website1'],
                'place_id' =>  $place->id,
            ]);
        }

        if(!is_null($data['website2'])){
            $website2 = Website::create([
                'url' =>  $data['website2'],
                'place_id' =>  $place->id,
            ]);
        }
        $user = auth()->user();

        if (array_key_exists('tag', request()->input())) {

            foreach (request('tag') as $tag) {
                $place->tags()->syncWithoutDetaching($tag);
            }
        }

        return redirect('/search')->with('message', 'You added '. $place->name.'. Waiting for approval');;

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

    public function edit(Place $place){
        $days = ['Monday', 'Tuesday', 'Wendseday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $categories = Category::all();
        $tags = Tag::all();
        $update=true;
        return view('places.create', compact('days','categories', 'tags', 'place', 'update'));
    }
    public function update(Place $place){


        $user = Auth::user();

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'description' => 'required|min:10|max:255',
            'phone1' => 'nullable|min:3|phone',
            'email1' => 'nullable|min:3|max:40|email',
            'website1' => 'nullable|min:3|max:70|url',
            'phone2' => 'nullable|numeric|phone',
            'email2' => 'nullable|min:3|max:40|email',
            'website2' => 'nullable|min:3|max:70|url',
            'category' => 'required',
            'multiple_images.*' => 'sometimes|file|image|max:8000',
        ]);
        if ($place->address == $data['address']){
            $lat = $place->lat;
            $lng = $place->lng;
        } else {
            $address = $data['address'];
            $address = str_replace(" ","+", $address);
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyAY9df1pMrDrLQ7JcEFuBZh0CdtpUFMdAY');
            $latlng = $response->json()['results'][0]['geometry']['location'];
            $lat = $latlng['lat'];
            $lng = $latlng['lng'];
        }
        $place->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'lat' => $lat,
            'lng' => $lng,
            'description' => $data['description'],
            'category_id' => $data['category'],
            'approved' => false,
        ]);


        if(request()->has('multiple_images')) {
            foreach($data['multiple_images'] as $img) {
                $img_name = $img->store('uploads', 'public');
                $img_data[] = $img_name;
            }

            if($place->images) {
                $place->update([
                    'images' => json_encode($img_data),
                ]);
            } else {
                $place->images = json_encode($img_data);
                $place->save();

            }

        }

        $website1 = null;
        $website2 = null;
        $email1 = null;
        $email2 = null;
        $phone1 = null;
        $phone2 = null;

        foreach($place->website as $val => $website){
            if($val == 0)$website1 = $website;
            if($val == 1)$website2 = $website;
        }
        foreach($place->emails as $val => $email){
            if($val == 0)$email1 = $email;
            if($val == 1)$email2 = $email;
        }
        foreach($place->phones as $val => $phone){
            if($val == 0)$phone1 = $phone;
            if($val == 1)$phone2 = $phone;
        }
        if(!is_null($data['phone1'])) {
            if($phone1){
                $phone1->update([
                    'number' => $data['phone1'],
                ]);
            } else {
                $phone1 = Phone::create([
                    'number' =>  $data['phone1'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if ($phone1) {
            $phone1->delete();
        }
        if(!is_null($data['phone2'])){
            if($phone2) {
                $phone2->update([
                    'number' => $data['phone2'],
                ]);
            } else {
                $phone2 = Phone::create([
                    'number' =>  $data['phone2'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if ($phone2) {
            $phone2->delete();
        }
        if(!is_null($data['email1'])) {
            if($email1) {
                $email1->update([
                    'email' => $data['email1'],
                ]);
            } else {
                $email1 = Email::create([
                    'email' =>  $data['email1'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if($email1){
            $email1->delete();
        }
        if(!is_null($data['email2'])){
            if($email2) {
                $email2->update([
                    'email' => $data['email2'],
                ]);
            } else {
                $email2 = Email::create([
                    'email' =>  $data['email2'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if($email2) {
            $email2->delete();
        }

        if(!is_null($data['website1'])) {
            if($website1) {
                $website1->update([
                    'url' => $data['website1'],
                ]);
            } else {
                $website1 = Website::create([
                    'url' =>  $data['website1'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if ($website1) {
            $website1->delete();
        }

        if(!is_null($data['website2'])){
            if($place->website->last()) {
                $place->website->last()->update([
                    'url' => $data['website2'],
                ]);
            } else {
                $website2 = Website::create([
                    'url' =>  $data['website2'],
                    'place_id' =>  $place->id,
                ]);
            }
        } else if ($website2) {
            $website2->delete();
        }
        foreach ($place->tags as $tag){
            $place->tags()->detach($tag->id);
        }
        if (array_key_exists('tag', request()->input())) {
            foreach (request('tag') as $tag) {
                $place->tags()->syncWithoutDetaching($tag);
            }
        }

        return redirect('/user/profile')->with('message', 'Succesfully updated object.  Waiting for approval');
    }

    public function destroy_from_search(Place $place){

       self::destroy($place);
       return redirect('/search')->with('message', 'Succesfully deleted object');

    }
    public function destroy_from_approve(Place $place){

        self::destroy($place);
        return redirect('/approve')->with('message', 'Succesfully deleted object');

    }
    public function destroy_from_userProfile(Place $place){

        self::destroy($place);
        return redirect('/user/profile')->with('message', 'Succesfully deleted object');

    }

    public function destroy(Place $place){

        foreach ($place->phones as $phone){
                $phone->delete();
        }
        foreach ($place->emails as $email){
            $email->delete();
        }
        foreach ($place->website as $website){
            $website->delete();
        }
        foreach ($place->reviews as $review){
            $review->delete();
        }
        foreach ($place->tags as $tag){
            $place->tags()->detach($tag->id);
        }

        $place->delete();

    }

}

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
            'phone1' => 'nullable|min:3|phone',
            'email1' => 'nullable|min:3|max:40|email',
            'website1' => 'nullable|min:3|max:70|url',
            'phone2' => 'nullable|numeric|phone',
            'email2' => 'nullable|min:3|max:40|email',
            'website2' => 'nullable|min:3|max:70|url',
            'category' => 'required',
            'multiple_images.*' => 'sometimes|file|image|max:8000',
        ]);

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
        if(request()->has('multiple_images')) {
            // dd('uco');
            foreach($data['multiple_images'] as $img) {

                $img_name = $img->store('uploads', 'public');
                $img_data[] = $img_name;
            }
            if($place->images) {
                dd($img_data);
                foreach(json_decode($place->images) as $img) {
                    $img_data[] = $img;
                }
            }

            $place->images = json_encode($img_data);
           // dd( $place->images);
        }
        $place->save();

        if(array_key_exists('phone1', $data) && !is_null($data['phone1'])) {
            $phone1 = new Phone();
            $phone1->number = $data['phone1'];
            $phone1->place_id = $place->id;
            $phone1->save();
        }
        if(array_key_exists('phone2', $data) && !is_null($data['phone2'])){
            $phone2 = new Phone();
            $phone2->number = $data['phone2'];
            $phone2->place_id = $place->id;
            $phone2->save();
        }
        if(array_key_exists('email1', $data) && !is_null($data['email1'])) {
            $email1 = new Email();
            $email1->email = $data['email1'];
            $email1->place_id = $place->id;
            $email1->save();
        }
        if(array_key_exists('email2', $data) && !is_null($data['email2'])){
            $email2 = new Email();
            $email2->email = $data['email2'];
            $email2->place_id = $place->id;
            $email2->save();
        }

        if(array_key_exists('website1', $data) && !is_null($data['website1'])) {
            $website1 = new Website();
            $website1->url = $data['website1'];
            $website1->place_id = $place->id;
            $website1->save();
        }

        if(array_key_exists('website2', $data) && !is_null($data['website2'])){
            $website2 = new Website();
            $website2->url = $data['website2'];
            $website2->place_id = $place->id;
            $website2->save();
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

    public function destroy(Place $place){

        foreach ($place->phones as $phone){
              //  $place->phones()->detach($phone->id);
                $phone->delete();
        }
        foreach ($place->emails as $email){
            //$place->emails()->detach($email->id);
            $email->delete();
        }
        foreach ($place->website as $website){
            //$place->website()->detach($website->id);
            $website->delete();
        }

        $place->delete();

        return redirect('/approve')->with('message', 'Succesfully deleted object');
    }

}

<?php

namespace App\Http\Controllers;
use \App\Tag;
use \App\Category;
use \App\Place;
use \App\Phone;
use \App\Email;
use \App\Website;
use \App\Review;
use \App\Workhour;
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
        $categories = Category::all()->sortBy('name');
        $tags = Tag::all()->sortBy('name');

        $place= new Place;
        $workhours = new Workhour;
        $place->workhours = $this->CheckWorkhours($workhours);
        $update=false;
        return view('places.create', compact('days','categories', 'tags', 'update', 'place'));
    }
    public function store(){
        $user = Auth::user();

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'description' => 'required|min:10|max:255',
            'phone1' => 'nullable|min:3',
            'email1' => 'nullable|min:3|max:40|email',
            'website1' => 'nullable|min:3|max:70|url',
            'phone2' => 'nullable|numeric',
            'email2' => 'nullable|min:3|max:40|email',
            'website2' => 'nullable|min:3|max:70|url',

            'monday-start1' => 'nullable|date_format:H:i|required_with:monday-end1',
            'monday-end1' => 'nullable|date_format:H:i|after:monday-start1|required_with:monday-start1',
            'monday-start2' => 'nullable|date_format:H:i|after:monday-end1|required_with:monday-end2',
            'monday-end2' => 'nullable|date_format:H:i|after:monday-start2|required_with:monday-start2',

            'tuesday-start1' => 'nullable|date_format:H:i|required_with:tuesday-end1',
            'tuesday-end1' => 'nullable|date_format:H:i|after:tuesday-start1|required_with:tuesday-start1',
            'tuesday-start2' => 'nullable|date_format:H:i|after:tuesday-end1|required_with:tuesday-end2',
            'tuesday-end2' => 'nullable|date_format:H:i|after:tuesday-start2|required_with:tuesday-start2',

            'wednesday-start1' => 'nullable|date_format:H:i|required_with:wednesday-end1',
            'wednesday-end1' => 'nullable|date_format:H:i|after:wednesday-start1|required_with:wednesday-start1',
            'wednesday-start2' => 'nullable|date_format:H:i|after:wednesday-end1|required_with:wednesday-end2',
            'wednesday-end2' => 'nullable|date_format:H:i|after:wednesday-start2|required_with:wednesday-start2',

            'thursday-start1' => 'nullable|date_format:H:i|required_with:thursday-end1',
            'thursday-end1' => 'nullable|date_format:H:i|after:thursday-start1|required_with:thursday-start1',
            'thursday-start2' => 'nullable|date_format:H:i|after:thursday-end1|required_with:thursday-end2',
            'thursday-end2' => 'nullable|date_format:H:i|after:thursday-start2|required_with:thursday-start2',

            'friday-start1' => 'nullable|date_format:H:i|required_with:friday-end1',
            'friday-end1' => 'nullable|date_format:H:i|after:friday-start1|required_with:friday-start1',
            'friday-start2' => 'nullable|date_format:H:i|after:friday-end1|required_with:friday-end2',
            'friday-end2' => 'nullable|date_format:H:i|after:friday-start2|required_with:friday-start2',

            'saturday-start1' => 'nullable|date_format:H:i|required_with:saturday-end1',
            'saturday-end1' => 'nullable|date_format:H:i|after:saturday-start1|required_with:saturday-start1',
            'saturday-start2' => 'nullable|date_format:H:i|after:saturday-end1|required_with:saturday-end2',
            'saturday-end2' => 'nullable|date_format:H:i|after:saturday-start2|required_with:saturday-start2',

            'sunday-start1' => 'nullable|date_format:H:i|required_with:sunday-end1',
            'sunday-end1' => 'nullable|date_format:H:i|after:sunday-start1|required_with:sunday-start1',
            'sunday-start2' => 'nullable|date_format:H:i|after:sunday-end1|required_with:sunday-end2',
            'sunday-end2' => 'nullable|date_format:H:i|after:sunday-start2|required_with:sunday-start2',

            'category' => 'required',
            'multiple_images.*' => 'sometimes|file|image|max:8000',
        ]);

        $lat = Geocoder::getCoordinatesForAddress($data['address'])['lat'];
        $lng = Geocoder::getCoordinatesForAddress($data['address'])['lng'];

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
/////////////workhours
        if(!is_null($data['monday-start1']) || !is_null($data['tuesday-start1']) || !is_null($data['wednesday-start1']) || !is_null($data['thursday-start1'])
            || !is_null($data['friday-start1']) || !is_null($data['saturday-start1']) || !is_null($data['sunday-start1'])){

            $workhours = Workhour::create([
                'monday_start1' => $data['monday-start1'],
                'monday_end1' => $data['monday-end1'],
                'monday_start2' => $data['monday-start2'],
                'monday_end2' => $data['monday-end2'],

                'tuesday_start1' => $data['tuesday-start1'],
                'tuesday_end1' => $data['tuesday-end1'],
                'tuesday_start2' => $data['tuesday-start2'],
                'tuesday_end2' => $data['tuesday-end2'],

                'wednesday_start1' => $data['wednesday-start1'],
                'wednesday_end1' => $data['wednesday-end1'],
                'wednesday_start2' =>$data['wednesday-start2'],
                'wednesday_end2' => $data['wednesday-end2'],

                'thursday_start1' => $data['thursday-start1'],
                'thursday_end1' => $data['thursday-end1'],
                'thursday_start2' => $data['thursday-start2'],
                'thursday_end2' => $data['thursday-end2'],

                'friday_start1' => $data['friday-start1'],
                'friday_end1' => $data['friday-end1'],
                'friday_start2' => $data['friday-start2'],
                'friday_end2' => $data['friday-end2'],

                'saturday_start1' => $data['saturday-start1'],
                'saturday_end1' => $data['saturday-end1'],
                'saturday_start2' => $data['saturday-start2'],
                'saturday_end2' =>$data['saturday-end2'],

                'sunday_start1' => $data['sunday-start1'],
                'sunday_end1' => $data['sunday-end1'],
                'sunday_start2' => $data['sunday-start2'],
                'sunday_end2' => $data['sunday-end2'],

                'place_id' =>  $place->id,
            ]);
        }


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
        $place->workhours = [];
        if($place->workhour) $place->workhours = $this->CheckWorkhours($place->workhour);
        $update=true;
        return view('places.create', compact('days','categories', 'tags', 'place', 'update'));
    }
    public function update(Place $place){


        $user = Auth::user();

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'description' => 'required|min:10|max:255',
            'phone1' => 'nullable|min:3',
            'email1' => 'nullable|min:3|max:40|email',
            'website1' => 'nullable|min:3|max:70|url',
            'phone2' => 'nullable|numeric',
            'email2' => 'nullable|min:3|max:40|email',
            'website2' => 'nullable|min:3|max:70|url',

            'monday-start1' => 'nullable|date_format:H:i|required_with:monday-end1',
            'monday-end1' => 'nullable|date_format:H:i|after:monday-start1|required_with:monday-start1',
            'monday-start2' => 'nullable|date_format:H:i|after:monday-end1|required_with:monday-end2',
            'monday-end2' => 'nullable|date_format:H:i|after:monday-start2|required_with:monday-start2',

            'tuesday-start1' => 'nullable|date_format:H:i|required_with:tuesday-end1',
            'tuesday-end1' => 'nullable|date_format:H:i|after:tuesday-start1|required_with:tuesday-start1',
            'tuesday-start2' => 'nullable|date_format:H:i|after:tuesday-end1|required_with:tuesday-end2',
            'tuesday-end2' => 'nullable|date_format:H:i|after:tuesday-start2|required_with:tuesday-start2',

            'wednesday-start1' => 'nullable|date_format:H:i|required_with:wednesday-end1',
            'wednesday-end1' => 'nullable|date_format:H:i|after:wednesday-start1|required_with:wednesday-start1',
            'wednesday-start2' => 'nullable|date_format:H:i|after:wednesday-end1|required_with:wednesday-end2',
            'wednesday-end2' => 'nullable|date_format:H:i|after:wednesday-start2|required_with:wednesday-start2',

            'thursday-start1' => 'nullable|date_format:H:i|required_with:thursday-end1',
            'thursday-end1' => 'nullable|date_format:H:i|after:thursday-start1|required_with:thursday-start1',
            'thursday-start2' => 'nullable|date_format:H:i|after:thursday-end1|required_with:thursday-end2',
            'thursday-end2' => 'nullable|date_format:H:i|after:thursday-start2|required_with:thursday-start2',

            'friday-start1' => 'nullable|date_format:H:i|required_with:friday-end1',
            'friday-end1' => 'nullable|date_format:H:i|after:friday-start1|required_with:friday-start1',
            'friday-start2' => 'nullable|date_format:H:i|after:friday-end1|required_with:friday-end2',
            'friday-end2' => 'nullable|date_format:H:i|after:friday-start2|required_with:friday-start2',

            'saturday-start1' => 'nullable|date_format:H:i|required_with:saturday-end1',
            'saturday-end1' => 'nullable|date_format:H:i|after:saturday-start1|required_with:saturday-start1',
            'saturday-start2' => 'nullable|date_format:H:i|after:saturday-end1|required_with:saturday-end2',
            'saturday-end2' => 'nullable|date_format:H:i|after:saturday-start2|required_with:saturday-start2',

            'sunday-start1' => 'nullable|date_format:H:i|required_with:sunday-end1',
            'sunday-end1' => 'nullable|date_format:H:i|after:sunday-start1|required_with:sunday-start1',
            'sunday-start2' => 'nullable|date_format:H:i|after:sunday-end1|required_with:sunday-end2',
            'sunday-end2' => 'nullable|date_format:H:i|after:sunday-start2|required_with:sunday-start2',

            'category' => 'required',
            'multiple_images.*' => 'sometimes|file|image|max:8000',
        ]);
        if ($place->address == $data['address']){
            $lat = $place->lat;
            $lng = $place->lng;
        } else {
            $lat = Geocoder::getCoordinatesForAddress($data['address'])['lat'];
            $lng = Geocoder::getCoordinatesForAddress($data['address'])['lng'];
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

        if($place->workhour) {
            $place->workhour->update([
                'monday_start1' => $data['monday-start1'],
                'monday_end1' => $data['monday-end1'],
                'monday_start2' => $data['monday-start2'],
                'monday_end2' => $data['monday-end2'],

                'tuesday_start1' => $data['tuesday-start1'],
                'tuesday_end1' => $data['tuesday-end1'],
                'tuesday_start2' => $data['tuesday-start2'],
                'tuesday_end2' => $data['tuesday-end2'],

                'wednesday_start1' => $data['wednesday-start1'],
                'wednesday_end1' => $data['wednesday-end1'],
                'wednesday_start2' => $data['wednesday-start2'],
                'wednesday_end2' => $data['wednesday-end2'],

                'thursday_start1' => $data['thursday-start1'],
                'thursday_end1' => $data['thursday-end1'],
                'thursday_start2' => $data['thursday-start2'],
                'thursday_end2' => $data['thursday-end2'],

                'friday_start1' => $data['friday-start1'],
                'friday_end1' => $data['friday-end1'],
                'friday_start2' => $data['friday-start2'],
                'friday_end2' => $data['friday-end2'],

                'saturday_start1' => $data['saturday-start1'],
                'saturday_end1' => $data['saturday-end1'],
                'saturday_start2' => $data['saturday-start2'],
                'saturday_end2' => $data['saturday-end2'],

                'sunday_start1' => $data['sunday-start1'],
                'sunday_end1' => $data['sunday-end1'],
                'sunday_start2' => $data['sunday-start2'],
                'sunday_end2' => $data['sunday-end2'],
            ]);
        } else {
            $workhours = Workhour::create([
                'monday_start1' => $data['monday-start1'],
                'monday_end1' => $data['monday-end1'],
                'monday_start2' => $data['monday-start2'],
                'monday_end2' => $data['monday-end2'],

                'tuesday_start1' => $data['tuesday-start1'],
                'tuesday_end1' => $data['tuesday-end1'],
                'tuesday_start2' => $data['tuesday-start2'],
                'tuesday_end2' => $data['tuesday-end2'],

                'wednesday_start1' => $data['wednesday-start1'],
                'wednesday_end1' => $data['wednesday-end1'],
                'wednesday_start2' => $data['wednesday-start2'],
                'wednesday_end2' => $data['wednesday-end2'],

                'thursday_start1' => $data['thursday-start1'],
                'thursday_end1' => $data['thursday-end1'],
                'thursday_start2' => $data['thursday-start2'],
                'thursday_end2' => $data['thursday-end2'],

                'friday_start1' => $data['friday-start1'],
                'friday_end1' => $data['friday-end1'],
                'friday_start2' => $data['friday-start2'],
                'friday_end2' => $data['friday-end2'],

                'saturday_start1' => $data['saturday-start1'],
                'saturday_end1' => $data['saturday-end1'],
                'saturday_start2' => $data['saturday-start2'],
                'saturday_end2' => $data['saturday-end2'],

                'sunday_start1' => $data['sunday-start1'],
                'sunday_end1' => $data['sunday-end1'],
                'sunday_start2' => $data['sunday-start2'],
                'sunday_end2' => $data['sunday-end2'],

                'place_id' => $place->id,
            ]);
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

    public function CheckWorkhours (Workhour $workhours){
        $hasWorkhours = [];
        if(!is_null($workhours->monday_start1)) array_push($hasWorkhours,"monday_start1");
        if(!is_null($workhours->monday_end1)) array_push($hasWorkhours,"monday_end1");
        if(!is_null($workhours->monday_start2)) array_push($hasWorkhours,"monday_start2");
        if(!is_null($workhours->monday_end2)) array_push($hasWorkhours,"monday_end2");
        if(!is_null($workhours->tuesday_start1)) array_push($hasWorkhours,"tuesday_start1");
        if(!is_null($workhours->tuesday_end1)) array_push($hasWorkhours,"tuesday_end1");
        if(!is_null($workhours->tuesday_start2)) array_push($hasWorkhours,"tuesday_start2");
        if(!is_null($workhours->tuesday_end2)) array_push($hasWorkhours,"tuesday_end2");
        if(!is_null($workhours->wednesday_start1)) array_push($hasWorkhours,"wednesday_start1");
        if(!is_null($workhours->wednesday_end1)) array_push($hasWorkhours,"wednesday_end1");
        if(!is_null($workhours->wednesday_start2)) array_push($hasWorkhours,"wednesday_start2");
        if(!is_null($workhours->thursday_start1)) array_push($hasWorkhours,"thursday_start1");
        if(!is_null($workhours->thursday_end1)) array_push($hasWorkhours,"thursday_end1");
        if(!is_null($workhours->thursday_start2)) array_push($hasWorkhours,"thursday_start2");
        if(!is_null($workhours->thursday_end2)) array_push($hasWorkhours,"thursday_end2");
        if(!is_null($workhours->friday_start1)) array_push($hasWorkhours,"friday_start1");
        if(!is_null($workhours->friday_end1)) array_push($hasWorkhours,"friday_end1");
        if(!is_null($workhours->friday_start2)) array_push($hasWorkhours,"friday_start2");
        if(!is_null($workhours->friday_end2)) array_push($hasWorkhours,"friday_end2");
        if(!is_null($workhours->saturday_start1)) array_push($hasWorkhours,"saturday_start1");
        if(!is_null($workhours->saturday_end1)) array_push($hasWorkhours,"saturday_end1");
        if(!is_null($workhours->saturday_start2)) array_push($hasWorkhours,"saturday_start2");
        if(!is_null($workhours->saturday_end2)) array_push($hasWorkhours,"saturday_end2");
        if(!is_null($workhours->sunday_start1)) array_push($hasWorkhours,"sunday_start1");
        if(!is_null($workhours->sunday_end1)) array_push($hasWorkhours,"sunday_end1");
        if(!is_null($workhours->sunday_start2)) array_push($hasWorkhours,"sunday_start2");
        if(!is_null($workhours->sunday_end2)) array_push($hasWorkhours,"sunday_end2");

        return $hasWorkhours;
    }

}

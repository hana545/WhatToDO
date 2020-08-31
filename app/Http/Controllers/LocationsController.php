<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Spatie\Geocoder\Facades\Geocoder;

use Illuminate\Support\Facades\Http;
use function MongoDB\BSON\toJSON;

class LocationsController extends Controller
{
    public function store(){

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
        ]);

        $address = $data['address'];
        $address = str_replace(" ","+", $address);
        $lat = Geocoder::getCoordinatesForAddress($data['address'])['lat'];
        $lng = Geocoder::getCoordinatesForAddress($data['address'])['lng'];/*
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyAY9df1pMrDrLQ7JcEFuBZh0CdtpUFMdAY');
        $latlng = $response->json()['results'][0]['geometry']['location'];
        $lat = $latlng['lat'];
        $lng = $latlng['lng'];*/

        $location = Location::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'lat' => $lat,
            'lng' => $lng,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/user/profile')->with('message', 'You added a new location '. $location->name);
    }

    public function update(Location $location){

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
        ]);

        $user = Auth::user();
        if ($location->address == $data['address']){
            $lat = $location->lat;
            $lng = $location->lng;
        } else {
            $address = $data['address'];
            $address = str_replace(" ","+", $address);
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyAY9df1pMrDrLQ7JcEFuBZh0CdtpUFMdAY');
            $latlng = $response->json()['results'][0]['geometry']['location'];
            $lat = $latlng['lat'];
            $lng = $latlng['lng'];
        }
        $location->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'lat' => $lat,
            'lng' => $lng,
        ]);

        return redirect('/user/profile')->with('message', 'You updated a location '. $location->name);
    }

    public function destroy(Location $location){


        $location->delete();

        return redirect('/user/profile')->with('message', 'You deleted a location '. $location->name);
    }

}

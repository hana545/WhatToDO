<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Spatie\Geocoder\Facades\Geocoder;

class LocationsController extends Controller
{
    public function store(){

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
        ]);
        $lat = Geocoder::getCoordinatesForAddress($data['address'])['lat'];
        $lng = Geocoder::getCoordinatesForAddress($data['address'])['lng'];
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
            $lat = Geocoder::getCoordinatesForAddress($data['address'])['lat'];
            $lng = Geocoder::getCoordinatesForAddress($data['address'])['lng'];
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

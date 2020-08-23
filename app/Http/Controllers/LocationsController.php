<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\Auth;

class LocationsController extends Controller
{
    public function store(){

        $data = request()->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:3',
        ]);

        $location = Location::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'lat' => 45.3190435,
            'lng' => 14.475843,
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

        $location->update([
            'name' => $data['name'],
            'address' => $data['address'],
        ]);

        return redirect('/user/profile')->with('message', 'You updated a location '. $location->name);
    }

    public function destroy(Location $location){


        $location->delete();

        return redirect('/user/profile')->with('message', 'You deleted a location '. $location->name);
    }

}

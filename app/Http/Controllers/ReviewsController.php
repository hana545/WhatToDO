<?php

namespace App\Http\Controllers;


use \App\Place;
use \App\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{

    public function storeReview(Place $place){
        $data = request()->validate([
            'starvalue' => 'required|min:1|max:5',
            'text_review' => 'nullable',

        ]);
        $user = Auth::user();
        if(!$user) return redirect('/search')->with('error', 'You need to login to leave a review');
        //dd(request());
        $review = new Review();
        $review->description = $data['text_review'];
        $review->star = $data['starvalue'];
        $review->user_id =  $user->id;
        $review->place_id = $place->id;
        $review->save();

        return redirect('/search')->with('message', 'Succesfully posted review');

    }
    public function updateReview(Review $review){

        $data = request()->validate([
            'starvalue' => 'required|min:1|max:5',
            'text_review' => 'nullable',

        ]);
        $user = Auth::user();
        if(!$user) return redirect('/search')->with('error', 'You need to login to leave a review');
        $review->update([
            'star' => $data['starvalue'],
            'description' => $data['text_review'],
        ]);

        return redirect('/search')->with('message', 'Succesfully updated your review');

    }
    public function updateReview_fromUserProfile(Review $review){

        $data = request()->validate([
            'starvalue' => 'required|min:1|max:5',
            'text_review' => 'nullable',

        ]);
        $user = Auth::user();
        if(!$user) return redirect('/user/profile')->with('error', 'You need to login to leave a review');
        $review->update([
            'star' => $data['starvalue'],
            'description' => $data['text_review'],
        ]);

        return redirect('/user/profile')->with('message', 'Succesfully updated your review');

    }
    public function destroy(Review $review){
        $review->delete();
        return redirect('/search')->with('message', 'Succesfully deleted your review');

    }

    public function destroy_fromUserProfile(Review $review){
        $review->delete();
        return redirect('/user/profile')->with('message', 'Succesfully deleted your review');

    }
}

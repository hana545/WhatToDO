<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");

    }
    public function updateUsername(Request $request)
    {

        $validatedData = $request->validate([
            'username' => 'required|string|min:4|',
        ]);

        //Change username
        $user = Auth::user();
        $user->name =  $validatedData['username'];
        $user->save();
        return redirect()->back()->with("success","Username changed successfully !");


    }

    public function suspend(User $user){
        $user->update([
            'suspended' => 'true',
        ]);
        return redirect()->back()->with("success","User ". $user->email." suspended !");
    }

    public function unsuspend(User $user){
        $user->update([
            'suspended' => 'false',
        ]);
        return redirect()->back()->with("success","User ". $user->email." unsuspended !");
    }
}

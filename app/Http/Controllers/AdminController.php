<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;

class AdminController extends Controller
{

    public function manageAdminsUsers(){
        $users = User::where('type', 0)->get();
        $admins = User::where('type', 1)->get();
        $authuser = Auth::user();
     //   dd($users);
        return view('admin.manageAdminsUsers', compact('users', 'admins', 'authuser'));

    }

    public function registerUser(){

        $data = request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'user_type' => ['required'],
        ]);
        $user =User::create([
            'type' =>  $data['user_type'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect('/admin/manage')->with('message', 'Succesfully added user');

    }
}

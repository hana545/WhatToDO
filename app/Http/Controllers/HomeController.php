<?php

namespace App\Http\Controllers;

use \App\Tag;
use \App\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
/*
    public function __construct()
    {
        $this->middleware('auth');
    }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function createTag(){
        $tags = Tag::all();

        return view('admin.createTag', compact('tags'));
    }
    public function createCategory(){
        $categories = Category::all();

        return view('admin.createCategory', compact('categories'));
    }
    public function storeTag(){
        $data = request()->validate([
            'name' => 'required|min:3',
        ]);
        $tag = Tag::create($data);

        return redirect('/addTag');
    }
    public function storeCategory(){
        $data = request()->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:3|max:255'
        ]);

        $category = new Category;
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->save();
        return redirect('/addCategory');
    }
}

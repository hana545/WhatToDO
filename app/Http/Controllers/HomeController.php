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
        ]);

        $category = new Category;
        $category->name = $data['name'];
        $category->save();
        return redirect('/addCategory');
    }
    public function destroyCategory(Category $category){

        if (!$category->places->isEmpty()){
            return redirect('/addCategory')->with('error', 'There are places under this category, you cant delete it');
        }
        $category->delete();

        return redirect('/addCategory')->with('message', 'Succesfully deleted category');
    }
    public function destroyTag(Tag $tag){



        return redirect('/addTag')->with('message', 'entered destroy');
    }
}

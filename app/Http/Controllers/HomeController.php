<?php

namespace App\Http\Controllers;

use \App\Tag;
use \App\Category;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
        $tags = Tag::all()->sortBy('name');

        return view('admin.createTag', compact('tags'));
    }
    public function createCategory(){
        $categories = Category::all()->sortBy('name');

        return view('admin.createCategory', compact('categories'));
    }
    public function storeTag(){
        $data = request()->validate([
            'name' => 'required|min:3',
        ]);
        $tag = Tag::create($data);

        return redirect('tag/create');
    }
    public function storeCategory(){
        $data = request()->validate([
            'name' => 'required|min:3',
        ]);

        $category = new Category;
        $category->name = $data['name'];
        $category->save();
        return redirect('category/create');
    }
    public function destroyCategory(Category $category){

        if (!$category->places->isEmpty()){
            return redirect('category/create')->with('error', 'There are places under this category, you cant delete it');
        }
        $category->delete();

        return redirect('category/create')->with('message', 'Succesfully deleted category');
    }
    public function destroyTag(Tag $tag){

        if($tag->places->count() == 0){
            $tag->delete();
            return redirect('tag/create')->with('message', 'Succesfully deleted tag');
        }
        return redirect('tag/create')->with('error', 'There are places connected to this tag, you cant delete it');
    }
}

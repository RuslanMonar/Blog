<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\Post;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id' , 'desc')->where('is_draft' , '0')->paginate(3);
        return view('pages.index', ['posts' => $posts,]);
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('post'));
    }
    public function TagOrCategory($slug)
    {
        $url = explode('/', $_SERVER['REQUEST_URI'])[1];
        $class = 'App\\'.ucfirst($url);
        $data = $class::where('slug', $slug)->firstOrFail();
        $posts = $data->posts()->paginate(4);
        $type = ($url == 'tag') ? 'тегом' : 'категорією'; 
        return view('pages.list', ['posts' => $posts , 'slug' => $slug , 'type' => $type, 'title' => $data->title]);
    }
    /* public function tag($slug, $string)
    {
        $tag = Tag::where('slug' , $slug)->firstOrFail();
        $posts = $tag->posts()->paginate(4); 
        return view('pages.list' , ['posts' => $posts , 'string' => $string , 'slug' =>$slug]);
    }
    public function category($slug , $string)
    {
        $category = Category::where('slug' , $slug)->firstOrFail();
        $posts = $category->posts()->paginate(4); 
        return view('pages.list' , ['posts' => $posts , 'string' => $string , 'slug' =>$slug]);
    } */
}

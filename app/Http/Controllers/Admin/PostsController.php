<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Category;
#use Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =  Post::all();
        return view('admin.posts.index',  ['posts' => $posts]);
    }
    public function user_posts()
    {
        $posts = Post::where('user_id' ,  Auth::user()->id)->get();
        return view('admin.posts.index',  ['posts' => $posts]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'image' => 'nullable|image',
        ]);
        $post = Post::add($request->all());
        $post->uploadImage($request->file('image'));
        $post->setTags($request->get('tags'));
        $post->setCategory($request->get('category_id'));
        $post->toggleFeatured($request->get('is_featured'));
        if(Auth::user()->is_admin){
        $post->toggleStatus($request->get('is_draft'));
        return redirect()->route('posts.index');
        }
        else{
        $post->setDraft();
        return redirect('/')->with('status' , 'Ваш пост відправлений на перевірку адміністратором');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        $selectedTags = $post->tags->pluck('id')->all();
        return view('admin.posts.edit', compact('categories', 'tags' , 'post' , 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->edit($request->all());
        $post->uploadImage($request->file('image'));
        $post->setTags($request->get('tags'));
        $post->setCategory($request->get('category_id'));
        $post->toggleFeatured($request->get('is_featured'));
        $post->toggleStatus($request->get('is_draft'));
        return redirect()->route('posts.index');
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->deleteTags();
        $post->remove();
        return redirect()->route('posts.index');
    }
}

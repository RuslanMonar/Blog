<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index' , compact('comments'));
    }
    public function toggle($id)
    {
        $comment = Comment::find($id);
        $comment->toggelStatus();
        return redirect()->back();
    }
    public function destroy($id)
    {
        Comment::find($id)->delete();
        return redirect()->back();
    }
}

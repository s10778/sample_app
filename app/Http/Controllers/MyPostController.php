<?php

namespace App\Http\Controllers;

use App\Models\Post;

class MyPostController extends Controller
{
    public function index()
    {
        $user=auth()->user()->id;
        $posts=Post::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(5);
        return view('post.mypost', compact('posts'));
    }
}

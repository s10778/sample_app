<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class MyCommentController extends Controller
{
    public function index()
    {
        $user = auth()->user()->id;
        $comments = Comment::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('post.mycomment', compact('comments'));
    }
}

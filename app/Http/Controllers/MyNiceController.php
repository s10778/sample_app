<?php

namespace App\Http\Controllers;

use App\Models\Nice;

class MyNiceController extends Controller
{
    public function index()
    {
        $user=auth()->user()->id;
        $nices=nice::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('post.mynice', compact('nices'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactCreateRequest;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(ContactCreateRequest $request)
    {
        $inputs = $request->validated();

        Contact::create($inputs);

        return back()->with('message', 'お問い合わせいただき、誠にありがとうございます');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Read;

class ShowContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('showContact.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('showContact.show', compact('contact'));;
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('message', 'お問い合わせを削除しました');
    }
}

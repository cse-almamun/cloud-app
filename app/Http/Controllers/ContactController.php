<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('user-views.admin-contact');
    }

    public function support()
    {
        return view('user-views.admin-contact');
    }

    public function sendMessage(Request $req)
    {
        $req->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);

        $data = $req->all();

        $send = Contact::create($data);
        if (!empty($send)) return back()->with('message', 'Message send successfully');
        return back()->with('error', 'Unable to send message');
    }
}

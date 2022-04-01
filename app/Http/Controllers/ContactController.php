<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

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

        if (isset($req->option) && $req->option === 'support') {
            $user = User::where('email', $req->email)->first();
            if ($user === null) return back()->with('error', 'User not associate with the email');
        }

        if (isset($req->question) && null === $req->question) {
            return back()->with('error', 'Please choose option');
        }

        $data = $req->all();

        $send = Contact::create($data);
        if (!empty($send)) return back()->with('message', 'Message send successfully');
        return back()->with('error', 'Unable to send message');
    }
}

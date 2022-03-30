<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class EmailVerificationController extends Controller
{
    public function verificationNotice()
    {
        $user = Auth::user();
        if (null !== $user->email_verified_at) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.verify-email');
    }

    public function verificationVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/dashboard')->with('success', 'Email verified successfull!');
    }

    public function verificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}

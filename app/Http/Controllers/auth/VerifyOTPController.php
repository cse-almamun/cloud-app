<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailOTP;
use App\Models\OtpToken;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\returnSelf;

class VerifyOTPController extends Controller
{
    public function sendOtp($email)
    {
        $token = sprintf("%06d", mt_rand(1, 999999));
        $data = [
            'token' => $token,
            'message' => "Please don't share the OTP with others. If you didn't ask for it please avoid this message."
        ];

        $OtpData = [
            'email' => $email,
            'token' => $token
        ];

        OtpToken::create($OtpData);

        Mail::to($email)->send(new SendEmailOTP($data));
    }





    public function viewOTPPage()
    {
        $verified = session()->get('OtpVerified');
        if ($verified) return redirect()->route('admin.dashboard');
        return view('auth.verify-otp');
    }


    public function processOTP(Request $request)
    {
        $email =  Auth::guard('admin')->user()->email;

        $OtpToken = OtpToken::where('email', $email)->orderByDesc('id')->firstOrFail();

        // return $OtpToken->token;
        if ($OtpToken->token == $request->otp_code) {
            $request->session()->put('OtpVerified', 1);
            return redirect()->route('admin.dashboard')->with('message', 'Successfully Logged in!');
        }

        return redirect()->back()->with('error', 'Incorrect OTP Code!');
    }

    public function resendOTP()
    {
        if (Auth::guard('admin')->check()) {
            $email =  Auth::guard('admin')->user()->email;
            $this->sendOtp($email);
            return redirect()->back()->with('message', 'New 6-digt code sent to your email');
        }
    }
}

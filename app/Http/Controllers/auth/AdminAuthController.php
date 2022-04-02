<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public  function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['adminLogout']]);
    }

    public function index()
    {
        return view('admin-views.login');
    }

    public function adminLogin(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required',
            'emoji_password' => 'required'
        ]);

        //check if user password is temporary redirect the request to reset password page
        $admin = DB::table('admins')->where('email', $request->email)->select('uuid', 'password', 'emoji_password', 'isTemp', 'temp_password')->first();
        if (empty($admin)) return redirect()->back()->with('error', 'User not found');
        if (!(empty($admin)) && $admin->isTemp && Hash::check($request->password, $admin->temp_password)) return redirect()->route('admin.reset.temp-password.view');

        //elese collect the credential
        $credetials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $emoji_password = Str::replace(' ', '', $request->emoji_password);
        $json = json_encode($emoji_password);
        if (Hash::check($request->password, $admin->password) && Hash::check($json, $admin->emoji_password)) {
            //authenticate the user and then redirect to dashboard
            if (Auth::guard('admin')->attempt($credetials)) {
                $verify_otp = new VerifyOTPController();
                $verify_otp->sendOtp($request->email);

                return redirect()->route('admin.verify.otp')->with('message', '6-digit OTP sent to your email');
                // return view('auth.verify-otp', ['email' => $request->email])->with('message', '6-digit OTP sent to your email');
            }
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->with('error', 'Incorrect Credential!');
    }

    public function adminLogout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->forget('OtpVerified');
            // $request->session()->invalidate();

            // $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }
}

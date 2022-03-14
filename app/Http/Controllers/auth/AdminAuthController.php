<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

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
            'password' => 'required'
        ]);
        //check if user password is temporary redirect the request to reset password page
        $admin = Admin::where('email', $request->email)->select('uuid', 'isTemp', 'temp_password')->first();
        if (!(empty($admin)) && $admin->isTemp && Hash::check($request->password, $admin->temp_password)) return redirect()->route('admin.reset.temp-password.view', $admin->uuid);

        //elese collect the credential
        $credetials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //authenticate the user and then redirect to dashboard
        if (Auth::guard('admin')->attempt($credetials)) return redirect()->intended('/admin')->with('message', 'Welcome Admin!');

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->with('error', 'Incorrect Credential!');
    }

    public function adminLogout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            // $request->session()->invalidate();

            // $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminResetPassword extends Controller
{
    public function viewTempPassReset()
    {
        return view('admin-views.reset-temp-password');
    }

    public function resetAdminTempPassword(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'temp_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'emoji_password' => 'required'
        ]);
        $check = DB::table('admins')->select('isTemp', 'temp_password')->where('email', $req->email)->first();
        if (!empty($check) && $check->isTemp && Hash::check($req->temp_password, $check->temp_password)) {
            $emoji_password = Str::replace(' ', '', $req->emoji_password);
            $data = [
                'password' => Hash::make($req->password),
                'isTemp' => 0,
                'emoji_password' => Hash::make(json_encode($emoji_password)),
                'temp_password' => NULL
            ];
            $udpate = Admin::where('email', $req->email)->update($data);
            if ($udpate) return redirect()->route('admin.login')->with('message', 'Password Successfully Changed!');
        }
        return redirect()->back()->with('error', 'Incorrect Temporary Password');
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminResetPassword extends Controller
{
    public function viewTempPassReset($uuid)
    {
        return view('admin-views.reset-temp-password', ['uuid' => $uuid]);
    }

    public function resetAdminTempPassword(Request $req)
    {
        $req->validate([
            'temp_password' => 'required|min:8|max:8',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);
        $check = DB::table('admins')->select('isTemp', 'temp_password')->where('uuid', $req->uuid)->first();
        if (!empty($check) && $check->isTemp && Hash::check($req->temp_password, $check->temp_password)) {
            $data = [
                'password' => Hash::make($req->password),
                'isTemp' => 0,
                'temp_password' => NULL
            ];
            $udpate = Admin::where('uuid', $req->uuid)
                ->update($data);
            if ($udpate) return redirect()->route('admin.login')->with('message', 'Password Successfully Changed!');
        }
        return redirect()->back()->with('error', 'Incorrect Temporary Password');
    }
}

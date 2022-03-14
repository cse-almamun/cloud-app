<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecurityCheckControlller extends Controller
{
    public function imageSecuieryCheck()
    {
        $authdata = session('pre-auth');
        $img =  DB::table('users')->select('security_image')->where('uuid', $authdata['uuid'])->first();

        return view('user-views.auth.security-image-check', compact('img'));
    }

    public function getSecurityImage($image)
    {
        $authdata = session('pre-auth');
        $path = 'app' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $authdata['uuid'] . DIRECTORY_SEPARATOR . $image;
        return response()->file(storage_path($path));
    }

    public function verifyUserImagePassword(Request $request)
    {
        if ($request->image_sequence === null) return back()->with('error', 'Please create puzzle');
        $preAuth = session('pre-auth');
        $lv = DB::table('users')->select('image_password')->where('uuid', $preAuth['uuid'])->first();

        if (Hash::check(Str::replace(',', '-', $request->image_sequence), $lv->image_password)) return redirect('security-emoji-check');

        return back()->with('error', 'Incorrect Image Password');
    }


    public function emojiSecuirityCheck()
    {
        return view('user-views.auth.security-emoji-check');
    }

    public function verifyUserEmojiPassword(Request  $request)
    {
        $validate = $request->validate([
            'emoji_password' => 'required|min:5'
        ]);
        if ($validate) {
            $preAuth = session('pre-auth');
            $lv = DB::table('users')->select('emoji')->where('uuid', $preAuth['uuid'])->first();

            if (Hash::check(json_encode($request->emoji_password), $lv->emoji)) {
                $credentials = [
                    'email' => $preAuth['email'],
                    'password' => session('security'),
                ];
                if (Auth::attempt($credentials)) {
                    session()->forget(['pre-auth', 'security']);
                    return redirect()->intended('dashboard');
                } else {
                    return redirect()->back()->with('error', 'Something Wrong');
                }

                // if (Hash::check(Str::replace(',', '-', $request->image_sequence), $lv->image_password)) {
                //     
                // } else {
                //     return redirect('home')->with('error', 'Incorrect Image Password');
                // }
            } else {
                return back()->with('error', "Incorrect Emoji Password");
                // return redirect()->route('home')->with('error', 'Incorrect Emoji Password');
            };
        }
    }
}

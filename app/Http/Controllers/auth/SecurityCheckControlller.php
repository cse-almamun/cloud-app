<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecurityCheckControlller extends Controller
{
    public $limit = 3;
    public function imageSecurityCheck()
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
        $attempt = (session()->has('attempt-1')) ? session('attempt-1') : 0;
        $preAuth = session('pre-auth');
        $lv = DB::table('users')->select('image_password')->where('uuid', $preAuth['uuid'])->first();

        if (Hash::check(Str::replace(',', '-', $request->image_sequence), $lv->image_password)) {
            return redirect('security-emoji-check');
        } else {
            $attempt++;
            if ($attempt >= $this->limit) {
                session(['attempt-1' => $attempt]);
                User::where('uuid', $preAuth['uuid'])->update(['locked' => 1]);
                return redirect('support')->with('error', 'Your account has been locked!');
            } else {
                session(['attempt-1' => $attempt]);
            }
        }

        return back()->with('error', 'Incorrect Image Password');
    }


    public function emojiSecuirityCheck()
    {
        return view('user-views.auth.security-emoji-check');
    }

    public function verifyUserEmojiPassword(Request  $request)
    {
        $validate = $request->validate([
            'emoji_password' => 'required'
        ]);
        if ($validate) {
            $attempt = (session()->has('attempt-2')) ? session('attempt-2') : 0;
            $preAuth = session('pre-auth');
            $lv = DB::table('users')->select('emoji')->where('uuid', $preAuth['uuid'])->first();

            if (Hash::check(json_encode($request->emoji_password), $lv->emoji)) {
                $credentials = [
                    'email' => $preAuth['email'],
                    'password' => session('security'),
                ];
                if (Auth::attempt($credentials)) {
                    session()->forget(['pre-auth', 'security']);
                    return redirect()->route('user.dashboard');
                } else {
                    return redirect()->back()->with('error', 'Something Wrong');
                }
            } else {
                $attempt++;
                if ($attempt >= $this->limit) {
                    session(['attempt-2' => $attempt]);
                    User::where('uuid', $preAuth['uuid'])->update(['locked' => 1]);
                    return redirect('support')->with('error', 'Your account has been locked!');
                } else {
                    session(['attempt-2' => $attempt]);
                }
                return back()->with('error', "Incorrect Emoji Password");
            };
        }
    }
}

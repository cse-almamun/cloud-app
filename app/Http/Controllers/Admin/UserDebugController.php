<?php

namespace App\Http\Controllers\Admin;

use App\Helper\HelperUtil;
use App\Http\Controllers\Controller;
use App\Mail\ResetSecurityPassword;
use App\Models\File;
use App\Models\SecurityReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserDebugController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->query('search');
        if (empty($data)) return view('admin-views.users');
        if ($data) {
            $users = User::where('email', $data)
                ->orWhere('uuid', $data)
                ->orWhere('first_name',  'like', '%' . $data . '%')
                ->orWhere('last_name', 'like', '%' . $data . '%')
                ->get();
            return view('admin-views.users', compact('users'));
        }
        return view('admin-views.users');
    }

    public function debugUser($uuid)
    {

        $user = User::where('uuid', $uuid)->firstOrFail();

        $total_folder = HelperUtil::countFolder($uuid);
        $used_storage = HelperUtil::totalUsedStorage($uuid);
        $size = HelperUtil::readableFileSize($used_storage);
        $total_files = HelperUtil::countFiles($uuid);

        return view('admin-views.user-debug', compact(['user', 'total_folder', 'size', 'total_files']));
    }

    public function getUserImages($uuid, $item)
    {
        $img = DB::table('users')->where('uuid', $uuid)->select('avatar', 'security_image')->first();
        $path = null;
        if (Str::lower($item) == 'avatar') {
            $path = 'app' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $uuid . DIRECTORY_SEPARATOR . $img->avatar;
        }
        if (Str::lower($item) == 'security-image') {
            $path = 'app' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $uuid . DIRECTORY_SEPARATOR . $img->security_image;
        }

        return response()->file(storage_path($path));
    }


    public function resetEmojiImagePasswordToken(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required'
        ]);



        if (null === $request->reset_option) return back()->with('error', 'Please chose password reset option');
        $option = $request->reset_option;
        $user_uuid = $request->user_uuid;

        $user = User::where('uuid', $user_uuid)->firstOrFail();
        switch ($option) {
            case 'reset_emoji':
                $url = 'reset/emoji-password';
                $check =  $this->insertResetData($user, $url);
                if ($check) return back()->with('message', 'Emoji Password Reset Link Sent');
                break;
            case 'reset_image':
                $url = 'reset/image-password';
                $check = $this->insertResetData($user, $url);
                if ($check) return back()->with('message', 'Image Password Reset Link Sent');
                break;

            default:
                break;
        }
        return back()->with('error', 'Something wrong try again');
    }


    public function insertResetData($user, $url)
    {
        $token = Str::random(60);
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $data = [
            'user_uuid' => $user->uuid,
            'token' => Hash::make($token),
            'otp' => $otp

        ];

        $insert = SecurityReset::create($data);
        if (null !== $insert) {
            $credential = [
                'subject' => 'Reset Security Password',
                'fullName' => $user->first_name . ' ' . $user->last_name,
                'url' => $url . '/' . $insert->id . '/' . $token . '/' . $user->uuid . '?email=' . $user->email,
                'otp' => $otp,
            ];
            Mail::to($user->email)->send(new ResetSecurityPassword($credential));

            return true;
        } else {
            return false;
        }
    }


    public function updateUserStorageLimit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'uuid' => 'required|uuid',
            'storage' => 'required|numeric'
        ]);

        $user = User::where('uuid', $request->uuid)->firstOrFail();

        if (null !== $user) {
            $user->storage = $request->storage;
            $user->save();
            return back()->with('message', 'Successfully updated the storage limit');
        }
        return back()->with('error', 'Something wrong!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserDebugController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->query('search');
        if ($data) {
            $users = User::where('email', $data)
                ->orWhere('uuid', $data)
                ->orWhere('first_name',  'like', '%' . $data . '%')
                ->orWhere('last_name', 'like', '%' . $data . '%')->get();
            return view('admin-views.users', compact('users'));
        }
        return view('admin-views.users');
    }

    public function debugUser($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        return view('admin-views.user-debug', compact('user'));
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
}

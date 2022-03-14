<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileSettingController extends Controller
{


    public function index()
    {
        $user = User::where('uuid', Auth::user()->uuid)->first();
        $questions =  UserSecurityQuestion::where('user_uuid', Auth::user()->uuid)
            ->join('questions', 'questions.uuid', '=', 'user_security_questions.question_uuid')
            ->select('user_security_questions.*', 'questions.question')->get();

        return view('user-views.dashboard.settings', compact(['user', 'questions']));
    }

    public function getUserAvatar($image)
    {
        $uuid = Auth::user()->uuid;
        $path = 'app' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $uuid . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $image;
        if (Storage::exists($path)) return response()->file(storage_path($path));
        return false;
    }

    public function updateAvatar(Request $request)
    {
        return $request->all();
    }
}

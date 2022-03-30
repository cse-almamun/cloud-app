<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $path = 'app' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $uuid . DIRECTORY_SEPARATOR . $image;
        if (Storage::exists('users' . DIRECTORY_SEPARATOR . $uuid . DIRECTORY_SEPARATOR . $image)) return response()->file(storage_path($path));
        return false;
    }

    /**
     * Update user avatar
     * encode and decode base64 image data
     * remove the old image from the directory
     * update the new name into database table
     * store new image file into storage directory
     */

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'uuid' => 'required|uuid',
            'data' => 'required'
        ]);

        $user = User::where('uuid', $request->uuid)->firstOrFail();

        if (null !== $user) {
            $path = 'users' . DIRECTORY_SEPARATOR . $request->uuid;
            $imageName = Str::random(14) . '.png';
            if (null !== $user->avatar) {
                if (Storage::exists($path . DIRECTORY_SEPARATOR . $user->avatar)) Storage::delete($path . DIRECTORY_SEPARATOR . $user->avatar);
            }
            $user->avatar = $imageName;
            $user->save();
            $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $request->data);
            $path = $path . DIRECTORY_SEPARATOR . $imageName;
            Storage::put($path, base64_decode($base64Image));
            return back()->with('message', 'Image uploaded successfully');
        };

        return back()->with('error', 'Someting wrong!');
    }


    /**
     * update user pesonal information like firstName and lastName
     */

    public function updateUserPersonalInfo(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $user = User::where('uuid', $request->uuid)->firstOrFail();

        if (null !== $user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();

            return back()->with('message', 'Information Updated Successfully');
        }
        return back()->with('error', 'Something wrong!');
    }


    /**
     * update user security question answere
     */


    public function updateSecurityQuestionAnswer(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required|uuid',
            'seq_answer_uuid' => 'required|uuid',
            'answer' => 'required|string'
        ]);

        $securityQuestionAnswer = UserSecurityQuestion::where('uuid', $request->seq_answer_uuid)->firstOrFail();

        if (null !== $securityQuestionAnswer && $securityQuestionAnswer->user_uuid === $request->user_uuid) {
            $output = Str::replace('!\s+!', ' ', $request->answer);
            $securityQuestionAnswer->answer = Str::replace(' ', '-', $output);
            $securityQuestionAnswer->save();
            return back()->with('sucess', 'Question answer has been updated successfully!');
        }
        return back()->with('error', 'Something Wrong!');
    }
}

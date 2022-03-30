<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\SecurityReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ResetEmojiImagePasswordController extends Controller
{
    public function viewImageEmojiResetPage($action, $id, $token, $uuid, Request $request)
    {

        $data = SecurityReset::findOrFail($id);
        if (null === $data) abort(404);
        if ($data->used) return redirect()->to('/support')->with('error', 'The token already expired or used.');
        if (Hash::check($token, $data->token) && ($uuid === $data->user_uuid)) {
            $data = (object)[
                'action' => $action,
                'id' => $id,
                'uuid' => $uuid,
                'email' => $request->query('email')
            ];

            return view('user-views.auth.reset-image-emoji-password')->with(['data' => $data]);
        }

        return abort(404, 'Invalid url');
    }


    public function emojiPasswordResetProcess(Request $request)
    {

        $request->validate([
            'id' => 'required|numeric',
            'uuid' => 'required|uuid',
            'otp' => 'required|numeric',
            'emoji_password' => 'required'
        ]);


        $srdata = SecurityReset::findOrFail($request->id);

        if ($srdata->otp !== $request->otp) return back()->with('error', 'Incorrect OTP Code!');

        $user = User::where('uuid', $request->uuid)->firstOrFail();

        if (null !== $user) {
            $user->emoji = Hash::make(json_encode($request->emoji_password));
            $user->save();

            $srdata->used = 1;
            $srdata->save();

            return redirect()->route('home')->with('message', 'Your emoji password has been updated successfully!!');
        }

        return back()->with('error', 'Something wrong, try again!!');
    }

    public function imagePasswordResetProcess(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'uuid' => 'required|uuid',
            'data' => 'required',
            'otp' => 'required|numeric',
            'image' => 'required',
            'image_sequence' => 'required'
        ]);

        $srdata = SecurityReset::findOrFail($request->id);

        if ($srdata->otp !== $request->otp) return back()->with('error', 'Incorrect OTP Code!');

        $user = DB::table('users')->select('uuid', 'security_image')->where('uuid', $request->uuid)->first();

        if (null !== $user) {
            $path = 'users/' . $user->uuid;
            $imageName = Str::random(14) . '.png';
            if (Storage::exists($path . DIRECTORY_SEPARATOR . $user->security_image)) Storage::delete($path . DIRECTORY_SEPARATOR . $user->security_image);
            if ($request->file('image')) {
                User::where('uuid', $user->uuid)->update([
                    'security_image' => $imageName,
                    'image_password' => Hash::make(Str::replace(',', '-', $request->image_sequence))
                ]);
                $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $request->data);
                $path = $path . DIRECTORY_SEPARATOR . $imageName;
                Storage::put($path, base64_decode($base64Image));
                // $request->image->storeAs($path, $request->image->getClientOriginalName());
            };

            $srdata->used = 1;
            $srdata->save();

            return redirect()->route('home')->with('message', 'Your image password has been updated successfully!!');
        }

        return back()->with('error', 'Something wrong, try again!!');
    }
}

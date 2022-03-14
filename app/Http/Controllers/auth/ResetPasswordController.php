<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\UserSecurityQuestion;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('user-views.auth.forgot-password');
    }

    public function checkSecuirityQuestion(Request $request)
    {
        // return $request->query('email');
        $question = DB::table('user_security_questions as usq')
            ->join('questions as q', 'q.uuid', '=', 'usq.question_uuid')
            ->join('users as u', 'u.uuid', '=', 'usq.user_uuid')
            ->where('u.email', $request->query('email'))
            ->select('usq.uuid', 'usq.user_uuid', 'q.question')
            ->orderByRaw('RAND()')
            ->limit(1)
            ->first();

        if (empty($question)) return redirect('forgot-password')->with('error', 'User not found');

        return view('user-views.auth.security-question-check', compact('question'));
    }

    public function getPasswordResetLink(Request $req)
    {
        $req->validate(['email' => 'required|email']);
        $data = UserSecurityQuestion::where('uuid', $req->answer_uuid)->select('answer')->first();

        if ($req->answer === $data->answer) {
            $status  = Password::sendResetLink($req->only('email'));
            return $status === Password::RESET_LINK_SENT
                ? redirect()->route('home')->with(['message' => __($status)])
                : redirect()->route('home')->withErrors(['error' => __($status)]);
        } else {
            return back()->with('error', 'Incorrect question answer');
        };
    }

    public function resetViewPage($token)
    {
        return view('user-views.auth.reset-password', ['token' => $token]);
    }



    public function resetUserPassord(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'locked' => 0,
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                // $user->locked = 0;
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('message', __($status))
            : back()->withErrors(['error' => [__($status)]]);
    }
}

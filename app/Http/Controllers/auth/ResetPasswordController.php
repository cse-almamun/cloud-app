<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user = User::where('email', $request->email)->select('uuid')->firstOrFail();
        $questions = DB::table('user_security_questions as usq')
            ->join('questions as q', 'q.uuid', '=', 'usq.question_uuid')
            ->join('users as u', 'u.uuid', '=', 'usq.user_uuid')
            ->where('u.email', $request->query('email'))
            ->select('usq.uuid', 'usq.user_uuid', 'q.question')
            ->get();

        if (empty($questions)) return redirect('forgot-password')->with('error', 'User not found');

        return view('user-views.auth.security-question-check', compact(['questions', 'user']));
    }

    public function getPasswordResetLink(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
        ]);
        $check1 = $this->checkSecurityQuestionAnswer($req->answer_uuid_1, Str::replace(' ', '-', $req->answer_1));
        $check2 = $this->checkSecurityQuestionAnswer($req->answer_uuid_2, Str::replace(' ', '-', $req->answer_2));
        $check3 = $this->checkSecurityQuestionAnswer($req->answer_uuid_3, Str::replace(' ', '-', $req->answer_3));


        if ($check1 && $check2 &&  $check3) {
            $status  = Password::sendResetLink($req->only('email'));
            return $status === Password::RESET_LINK_SENT
                ? redirect()->route('home')->with(['message' => __($status)])
                : redirect()->route('home')->withErrors(['error' => __($status)]);
        } else {
            if (!$check1) return back()->with('error', 'Incorrect secuirty answer for first question');
            if (!$check2) return back()->with('error', 'Incorrect secuirty answer for second question');
            if (!$check3) return back()->with('error', 'Incorrect secuirty answer for third question');
        }
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



    public function checkSecurityQuestionAnswer($answer_uuid, $user_answer)
    {
        $data = UserSecurityQuestion::where('uuid', $answer_uuid)->select('answer')->first();

        if ($user_answer === $data->answer) return true;

        return false;
    }
}

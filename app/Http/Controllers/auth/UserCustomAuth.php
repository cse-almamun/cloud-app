<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Questions;
use App\Models\UserSecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class UserCustomAuth extends Controller
{
    public $limit = 3;
    public function loginView()
    {
        return view('user-views.login');
    }

    public function userLoginProcess(Request $request)
    {


        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validate) {
            $attempt = (session()->has('attempt')) ? session('attempt') : 0;
            $lv = DB::table('users')->select(['uuid', 'email', 'password', 'locked', 'emoji', 'image_password'])->where('email', $request->email)->first();
            if (!empty($lv)) {
                if ($lv->locked) return redirect('forgot-password')->with('error', 'Your account has been locked!');
                if (Hash::check($request->password, $lv->password)) {

                    $pre_auth = [
                        'email' => $lv->email,
                        'uuid' => $lv->uuid,
                    ];
                    if (session()->has('pre-auth') || session()->has('security') || session()->has('attempt')) {
                        session()->forget(['pre-auth', 'security', 'attempt']);
                    }
                    session(['security' => $request->password]);

                    session(['pre-auth' => $pre_auth]);
                    return redirect('security-image-check');
                } else {
                    $attempt++;
                    if ($attempt >= $this->limit) {
                        session(['attempt' => $attempt]);
                        User::where('uuid', $lv->uuid)->update(['locked' => 1]);
                        return redirect('forgot-password')->with('error', 'Your account has been locked!');
                    } else {
                        session(['attempt' => $attempt]);
                    }
                }
            }
            return redirect()->route('home')->with('error', 'Incorrect Credential');
        }
    }

    public function registrationView()
    {
        $questions = Questions::all();
        return view('user-views.registration', compact('questions'));
    }

    public function registrationProcess(Request $request)
    {
        $data = $request->all();

        $check = $this->createUser($data);

        if (!empty($check)) {
            $userQuestions = [
                [
                    'uuid' => Str::uuid()->toString(),
                    'user_uuid' => $check->uuid,
                    'question_uuid' => $request->question_one,
                    'answer' => Str::replace(' ', '-', $request->question_one_ans)
                ],
                [
                    'uuid' => Str::uuid()->toString(),
                    'user_uuid' => $check->uuid,
                    'question_uuid' => $data['question_two'],
                    'answer' => Str::replace(' ', '-', $data['question_two_ans'])
                ],
                [
                    'uuid' => Str::uuid()->toString(),
                    'user_uuid' => $check->uuid,
                    'question_uuid' => $data['question_three'],
                    'answer' => Str::replace(' ', '-', $data['question_three_ans'])
                ]
            ];
            $path = 'users/' . $check->uuid;
            UserSecurityQuestion::insert($userQuestions);
            Storage::makeDirectory($path);

            if ($request->file('image') || $request->data) {
                $imageName = Str::random(14) . '.png';
                User::where('uuid', $check->uuid)->update(['security_image' => $imageName]);


                $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $request->data);
                $path = $path . DIRECTORY_SEPARATOR . $imageName;
                Storage::put($path, base64_decode($base64Image));
            };


            event(new Registered($check));
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            Auth::attempt($credentials);
            return redirect()->route('verification.notice')->with('message', 'We sent a verification email, please check your inbox.');
        }
        return redirect('registration')->with('error', 'Ops! there is somthing wrong');
    }



    //create new new user to the database

    public function createUser(array $data)
    {
        $dbData = [
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['telephone'],
            'emoji' => Hash::make(json_encode($data['emoji_password'])),
            'image_password' => Hash::make(Str::replace(',', '-', $data['image_sequence']))
        ];


        return User::create($dbData);
    }

    public function secuirityQuestionView($uuid)
    {
        $data = User::where('uuid', $uuid)->first();
        if ($data->complete) {
            echo 'profile is complete' + $data->uuid;
        } else {
            $questions = Questions::all();

            return view('user-views.questions.view', compact('questions'));
        };
    }

    public function checkUserEmail(Request $request)
    {
        $user =  User::select('email')->where('email', $request->email)->first();
        //return $user;
        if (empty($user)) {
            return "true";
        } else {
            return "false";
        }
    }
    public function checkUserPhone(Request $request)
    {
        $user =  User::select('phone_number')->where('phone_number', $request->telephone)->first();
        //return $user;
        if (empty($user)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function userLogOut(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
        }

        return redirect()->route('home');
    }
}

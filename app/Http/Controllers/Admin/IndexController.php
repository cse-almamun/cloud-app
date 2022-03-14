<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReplyContactMessage;
use App\Mail\SendTempPassword;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\File;
use App\Models\User;
use App\Models\UserSecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::all();
        $admins = Admin::all();
        return view('admin-views.index', compact(['admins', 'contacts']));
    }




    public function adminUsers()
    {
        $admins = Admin::all();
        return view('admin-views.admin-list', compact('admins'));
    }

    public function addAdmin(Request $request)
    {
        $temPassword = Str::random(8);
        $admin = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'null',
            'temp_password' => Hash::make($temPassword),
            'isTemp' => '1',
            'role' => $request->role,
        ];
        $admin = Admin::create($admin);
        if ($admin) {
            $data = [
                'name' => $admin->name,
                'email' => $admin->email,
                'tempPass' => $temPassword,
                'message' => 'Your account has been created successfully. Below is your account credential. Please use them to login to your Admin Account'
            ];
            Mail::to($admin->email)->send(new SendTempPassword($data));
            return redirect()->route('admin.employee')->with('message', 'Admin Added Successfuly!');
        };
        return redirect()->route('admin.employee')->with('error', 'Opps! Something Wrong.');
    }


    public function updateEmployee(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];
        $admin = Admin::where('uuid', $request->uuid)->update($data);
        if ($admin) return redirect()->back()->with('message', 'Admin Information Updated Successfully');
    }



    public function readMessage(Request $request)
    {
        $contact  = Contact::where('uuid', $request->uuid)->first();
        if ($contact->read === 0) {
            $contact->read = 1;
            $contact->save();
        }

        return response()->json($contact);
    }

    public function replyContactMessage(Request $req)
    {
        $data = [
            'fullName' => $req->full_name,
            'subject' => $req->subject,
            'message' => $req->message

        ];

        Mail::to($req->to_email)
            ->send(new ReplyContactMessage($data));

        return redirect()->back()->with('message', 'Email send Successfully!');
    }


    public function setTemporaryPassword(Request $req)
    {
        $data = [];
        $admin = Admin::where('uuid', $req->uuid)->first();
        if ($admin) {
            $randPass = Str::random(8);
            $admin->password = NULL;
            $admin->isTemp = 1;
            $admin->temp_password = Hash::make($randPass);
            $admin->save();

            $data = [
                'name' => $admin->name,
                'email' => $admin->email,
                'tempPass' => $randPass,
                'message' => 'Your password has been reseted. Below is your temporary passowrd. Please use them to login to your Admin Account'
            ];
            Mail::to($admin->email)->send(new SendTempPassword($data));

            $data = ['success' => true];
            return response()->json($data);
        } else {
            $data = ['success' => false];
            return response()->json($data);
        }
    }
}

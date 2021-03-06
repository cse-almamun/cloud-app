<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{

    public function index()
    {
        // return Auth::user()->uuid;

        $folders = Folder::where('user_uuid', Auth::user()->uuid)->get();
        return view('user-views.dashboard.folders', compact('folders'));
    }

    public function getUserFolders()
    {
        $folders =  User::where('uuid', Auth::user()->uuid)->first()->folders;

        return response()->json($folders);
    }

    public function folderFiles($uuid)
    {
        //elequoent example
        $files = Folder::where('uuid', $uuid)->first()->files;
        //query example
        // $files = File::where(['folder_uuid' => $uuid, 'user_uuid' => Auth::user()->uuid])->get();
        return view('user-views.dashboard.files', compact('files'));
    }


    public function makeFolder(Request $req)
    {
        $path = 'users/' . Auth::user()->uuid . '/' . $req->folder;
        $data = [
            'user_uuid' => Auth::user()->uuid,
            'name' => $req->folder,
            'path' => $path
        ];
        if (Storage::exists($path)) return redirect('folders')->with('error', 'Folder already exist');


        $create = Folder::create($data);
        if ($create) {
            Storage::makeDirectory($path);
            return redirect('folders')->with('message', 'Folder Created Successfully');
        } else {
            return redirect('folders')->with('error', 'Ops! Unable to create directory');
        }
    }


    public function editFolder(Request $req)
    {
        $folder = DB::table('folders')->where(['uuid' => $req->folder_uuid, 'user_uuid' => Auth::user()->uuid])->first();
        if (!empty($folder)) {
            $newPath = "users" . DIRECTORY_SEPARATOR . $folder->user_uuid . DIRECTORY_SEPARATOR . $req->new_name;
            //update file name on table
            Folder::where('uuid', $req->folder_uuid)->update(['name' => $req->new_name, 'path' => $newPath]);
            //update file name storage directory
            Storage::move($folder->path, $newPath);
            return back()->with('message', 'Successfully updated!');
        }
        return back()->with('error', 'Update folder name failed');
    }

    public function deleteFolder(Request $req)
    {
        //return $req->folder_id;
        $find = Folder::where('uuid', $req->folder_id)->first();
        if (!empty($find)) {
            $path = 'users/' . $find->user_uuid . '/' . $find->name;
            $find->delete();
            Storage::deleteDirectory($path);
        }
        return redirect('folders')->with('message', 'Successfully Deleted!');;
    }
}

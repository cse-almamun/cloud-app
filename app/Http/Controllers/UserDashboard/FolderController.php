<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
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


        $file =  DB::table('files')->where(['uuid' => $req->file_uuid, 'user_uuid' => Auth::user()->uuid])->first();

        if (!empty($file)) {
            $folder = DB::table('folders')->where(['uuid' => $file->folder_uuid, 'user_uuid' => Auth::user()->uuid])->first();
            $extension = pathinfo(storage_path($file->path), PATHINFO_EXTENSION);
            $newName = $req->new_fileName . '.' . $extension;
            $newPath = $folder->path . '/' . $newName;
            //update file name on table
            File::where('uuid', $req->file_uuid)->update(['file_name' => $newName]);
            //update file name storage directory
            Storage::move($file->path, $newPath);
        }
        return back();
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
        return redirect('folders');
    }
}

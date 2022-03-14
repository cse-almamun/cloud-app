<?php

namespace App\Http\Controllers\UserDashboard;

use App\Helper\HelperUtil;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function uploadFiles(Request $req)
    {
        if (!HelperUtil::checkSpace($req->file->getSize(), Auth::user()->uuid)) return redirect()->back()->with('error', 'You dont have enough space to upload this file');

        $folder =  DB::table('folders')->select('name', 'path')->where('uuid', $req->folder_uuid)->first();
        $path = $folder->path . '/' . $req->file->getClientOriginalName();
        $data = [
            'folder_uuid' => $req->folder_uuid,
            'user_uuid' => Auth::user()->uuid,
            'file_name' => $req->file->getClientOriginalName(),
            'file_size' => $req->file->getSize(),
            'path' => $path
        ];

        $file = File::create($data);
        if (!empty($file)) $req->file('file')->storeAs($folder->path, $req->file->getClientOriginalName());

        return back();
    }

    public function editFiles(Request $req)
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

    public function deleteFile(Request $req)
    {
        $file = DB::table('files')->select('file_name', 'path')->where(['uuid' => $req->file_uuid, 'user_uuid' => Auth::user()->uuid])->first();
        // return 

        if (!empty($file)) {
            Storage::delete($file->path);
            File::where('uuid', $req->file_uuid)->delete();
        }
        return back();
    }

    public function downloadFile($fileUuid)
    {
        $filePath =  DB::table('files')->select('path')->where(['uuid' => $fileUuid])->first();
        return Storage::download($filePath->path);
    }

    public function findUser(Request $req)
    {
        $data = User::where('first_name', 'like', '%' . $req->search_value . '%')
            ->orWhere('last_name', 'like', '%' . $req->search_value . '%')
            ->orWhere('email', 'like', '%' . $req->search_value . '%')
            ->get();
        return response()->json($data);
    }
}

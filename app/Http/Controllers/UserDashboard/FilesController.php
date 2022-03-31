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
        // $path = $folder->path . '/' . $req->file->getClientOriginalName();
        $data = [
            'folder_uuid' => $req->folder_uuid,
            'user_uuid' => Auth::user()->uuid,
            'file_name' => $req->file->getClientOriginalName(),
            'file_size' => $req->file->getSize(),
            // 'path' => $path
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
            $filePath = $folder->path . DIRECTORY_SEPARATOR . $file->file_name;
            $extension = pathinfo(storage_path($filePath), PATHINFO_EXTENSION);
            $newName = $req->new_fileName . '.' . $extension;
            $newPath = $folder->path . DIRECTORY_SEPARATOR . $newName;
            //update file name on table
            File::where('uuid', $req->file_uuid)->update(['file_name' => $newName]);
            //update file name storage directory
            Storage::move($filePath, $newPath);
            return back()->with('message', 'File renamed successfully');
        }
        return back()->with('error', 'Operation Failed!');
    }

    public function deleteFile(Request $req)
    {
        $file = File::where(['uuid' => $req->file_uuid, 'user_uuid' => Auth::user()->uuid])->firstOrFail();

        if (!empty($file)) {
            $path = 'users' . DIRECTORY_SEPARATOR . $file->user_uuid . DIRECTORY_SEPARATOR . $file->folder->name . DIRECTORY_SEPARATOR . $file->file_name;
            Storage::delete($path);
            File::where('uuid', $req->file_uuid)->delete();
            return back()->with('message', 'File deleted successfully');
        }
        return back()->with('error', 'Operation Failed!');
    }

    public function downloadFile($fileUuid)
    {
        $file = File::where(['uuid' => $fileUuid, 'user_uuid' => Auth::user()->uuid])->firstOrFail();
        $filePath = 'users' . DIRECTORY_SEPARATOR . $file->user_uuid . DIRECTORY_SEPARATOR . $file->folder->name . DIRECTORY_SEPARATOR . $file->file_name;;
        return Storage::download($filePath);
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

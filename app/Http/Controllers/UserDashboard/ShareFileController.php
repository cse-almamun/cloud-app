<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\SharedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareFileController extends Controller
{
    //share file

    public function shareFile(Request $req)
    {
        $data = [
            'file_uuid' => $req->file_uuid,
            'shared_with' => $req->user_id
        ];
        $alreadyShared = SharedFile::where($data)->first();
        if (!empty($alreadyShared)) return back()->with('error', "Ops! Files already shared with with the user.");

        $shared = SharedFile::create($data);
        if (!empty($shared)) {
            File::where("uuid", $req->file_uuid)
                ->update(["status" => 0]);
            return back()->with('message', "File Shared Successfully");
        }

        return back()->with('error', "Ops! Something Wrong:(");
    }

    public function getSharedWithUserFiles()
    {
        $files =  SharedFile::where('shared_with', Auth::user()->uuid)
            ->join('files', 'files.uuid', '=', 'shared_files.file_uuid')
            ->join('users as u', 'u.uuid', '=', 'files.user_uuid')
            ->select('shared_files.*', 'files.file_name', 'files.file_size', 'u.first_name', 'u.last_name')
            ->orderByDesc('created_at')
            ->get();

        return view('user-views.dashboard.shared-files', compact('files'));
    }


    public function getSharedWithUserList($fileId)
    {
        $files = DB::table('shared_files as sf')
            ->select("sf.*", "u.first_name", "u.last_name", "u.email")
            ->join('users as u', 'u.uuid', "=", "sf.shared_with")
            ->where("file_uuid", $fileId)
            ->get();
        return response()->json($files, 200);
    }

    public function removeSharedWithUser($shareId)
    {
        $resp = SharedFile::where('uuid', $shareId)->firstOrFail();
        if (null !== $resp) {
            $final = $resp->delete();
            $list = SharedFile::where("file_uuid", $resp->file_uuid)->get();
            if (sizeof($list) == 0) {
                File::where("uuid", $resp->file_uuid)->update(['status' => 1]);
            }
            return response()->json($final, 200);
        }
    }
}

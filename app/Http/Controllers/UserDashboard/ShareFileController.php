<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\SharedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareFileController extends Controller
{
    //share file

    public function shareFile(Request $req)
    {
        // return $req->all();
        $data = [
            'file_uuid' => $req->file_uuid,
            'shared_with' => $req->user_id
        ];
        $alreadyShared = SharedFile::where($data)->first();
        if (!empty($alreadyShared)) return back()->with('error', "Ops! Files already shared with with the user.");

        $shared = SharedFile::create($data);
        if (!empty($shared)) return back()->with('message', "File Shared Successfully");

        return back()->with('error', "Ops! Something Wrong:(");
    }

    public function getSharedWithUserFiles()
    {
        $files =  SharedFile::where('shared_with', Auth::user()->uuid)
            ->join('files', 'files.uuid', '=', 'shared_files.file_uuid')
            ->select('shared_files.*', 'files.file_name', 'files.file_size')
            ->orderByDesc('created_at')
            ->get();

        return view('user-views.dashboard.shared-files', compact('files'));
    }
}

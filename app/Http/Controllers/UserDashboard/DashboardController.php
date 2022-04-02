<?php

namespace App\Http\Controllers\UserDashboard;

use App\Helper\HelperUtil;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_folder = HelperUtil::countFolder(Auth::user()->uuid);
        $files = File::where('user_uuid', Auth::user()->uuid)->orderByDesc('created_at')->limit(20)->get();
        $used_storage = HelperUtil::totalUsedStorage(Auth::user()->uuid);
        $size = HelperUtil::readableFileSize($used_storage);
        $total_files = HelperUtil::countFiles(Auth::user()->uuid);
        return view('user-views.dashboard.index', compact(['files', 'size', 'total_folder', 'total_files']));
    }


    public function calculateTotalMemory()
    {
        $total = File::where('user_uuid', Auth::user()->uuid)->sum('file_size');

        return HelperUtil::readableFileSize($total);
    }
}

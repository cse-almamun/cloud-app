<?php

namespace App\Helper;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;

class HelperUtil
{

    static function totalUsedStorage($uuid)
    {
        $used_space = File::where('user_uuid', $uuid)->sum('file_size');
        return $used_space;
    }

    static function readableFileSize($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }

    static function toGB($bytes, $decimal_places = 1)
    {
        return number_format($bytes / 1073741824, $decimal_places);
    }

    public static function checkSpace($file_size, $uuid)
    {
        $user = User::where('uuid', $uuid)->select('storage')->firstOrFail();
        $total_space = (int) $user->storage * 1073741824;
        $used_space = (int) HelperUtil::totalUsedStorage($uuid);
        $balance = $total_space - $used_space;

        return ($balance > 0 && $file_size < $balance) ? true : false;
    }

    public static function countFolder($uuid)
    {
        return  Folder::where('user_uuid', $uuid)->count();
    }

    public static function countFiles($uuid)
    {
        return  File::where('user_uuid', $uuid)->count();
    }
}

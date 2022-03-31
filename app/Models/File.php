<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use UuidTrait, HasFactory;

    protected $fillable = [
        'uuid',
        'folder_uuid',
        'user_uuid',
        'file_name',
        'file_size',
    ];


    protected $hidden = [
        'id',
        'path'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}

<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Folder extends Model
{
    use UuidTrait, HasFactory;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'name',
        'path'
    ];

    protected $hidden = [
        'id',
        'path'
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'folder_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}

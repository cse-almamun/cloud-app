<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedFile extends Model
{
    use UuidTrait, HasFactory;

    protected $fillable = [
        'uuid',
        'file_uuid',
        'shared_with'
    ];
    protected $hidden = [
        'id'
    ];
}

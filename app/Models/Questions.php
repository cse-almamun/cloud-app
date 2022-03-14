<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use UuidTrait, HasFactory;


    protected $fillable = [
        'uuid',
        'question'
    ];
    protected $hidden = [
        'id'
    ];
}

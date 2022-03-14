<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use UuidTrait, HasFactory;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'question',
        'email',
        'message'
    ];

    protected $hidden = [
        'id'
    ];
}

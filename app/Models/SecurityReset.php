<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_uuid',
        'token',
        'otp'
    ];
}

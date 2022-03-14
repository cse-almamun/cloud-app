<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSecurityQuestion extends Model
{
    use UuidTrait, HasFactory;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'question_uuid',
        'answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }


    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_uuid', 'uuid');
    }
}

<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}

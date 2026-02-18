<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    public function detail() : HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
